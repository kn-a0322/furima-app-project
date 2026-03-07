<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Requests\PurchaseRequest;


class PurchaseController extends Controller
{
    public function purchase(PurchaseRequest $request, Item $item_id)
    {
        $item = $item_id;
        $profile = auth()->user()->profile;

        // 支払い方法の選択値とビューに表示するラベルの対応
        $paymentLabels = [
            'konbini'     => 'コンビニ払い',
            'credit_card' => 'カード支払い',
        ];

        // URLのクエリパラメーター(?payment_method=...)から選択値を取得
        $selectedPayment = $request->query('payment_method', '');

        // 選択値をラベルに変換（未選択の場合は空文字）
        $paymentLabel = $paymentLabels[$selectedPayment] ?? '';

        return view('purchase', compact('item', 'profile', 'selectedPayment', 'paymentLabel'));
    }
}
