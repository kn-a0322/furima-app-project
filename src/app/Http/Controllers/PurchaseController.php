<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    // 購入画面の表示
    public function purchase(Request $request, Item $item_id)
    {
        $item = $item_id;
        $profile = auth()->user()->profile;
        $selectedPayment = $request->query('payment_method', '');

        return view('purchase', compact('item', 'profile', 'selectedPayment'));
    }

    // 購入ボタン押下 → バリデーション → Stripe決済画面へリダイレクト
    public function purchaseStore(PurchaseRequest $request, Item $item_id)
    {
        $item = $item_id;

        // Stripe決済完了後に注文データを復元するため、セッションに一時保存する
        session([
            'pending_order' => [
                'payment_method'    => $request->payment_method,
                'shipping_postcode' => $request->postcode,
                'shipping_address'  => $request->address,
                'shipping_building' => $request->building,
            ]
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    // JPY（日本円）はセント換算不要。価格をそのまま渡す
                    'unit_amount' => (int) $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', $item->id),
            'cancel_url'  => route('purchase', $item->id),
        ]);

        // Stripeの決済画面へリダイレクト
        return redirect()->away($session->url);
    }

    // Stripe決済完了後の処理（success_url から遷移してくる）
    public function purchaseSuccess(Item $item_id)
    {
        $item = $item_id;

        // セッションに保存しておいた注文データを取り出す
        $orderData = session('pending_order');

        Order::create([
            'user_id'           => auth()->id(),
            'item_id'           => $item->id,
            'price'             => $item->price,
            'payment_method'    => $orderData['payment_method'],
            'shipping_postcode' => $orderData['shipping_postcode'],
            'shipping_address'  => $orderData['shipping_address'],
            'shipping_building' => $orderData['shipping_building'],
        ]);

        $item->update(['is_sold' => true]);

        // 使い終わったセッションデータを削除する
        session()->forget('pending_order');

        return redirect()->route('item.index')->with('message', '購入が完了しました');
    }
}
