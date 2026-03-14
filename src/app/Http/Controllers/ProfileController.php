<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function mypage(Request $request)
    {
        $user    = auth()->user();
        $profile = $user->profile;
        $page    = $request->query('page', 'sell');//クエリパラメータからpageを取得。デフォルトはsell

        if ($page === 'buy') {
            // 購入した商品：注文を経由してItemを取得
            $items = $user->orderItems;
        } else {
            // 出品した商品：自分が出品したItem
            $items = $user->items;
        }

        return view('mypage', compact('user', 'profile', 'items', 'page'));
    }

    // プロフィール編集画面（実装予定）
    public function edit()
    {
        return view('profile.edit');
    }
}
