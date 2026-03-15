<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    // マイページ（出品・購入タブ切り替え）
    public function mypage(Request $request)
    {
        $user    = auth()->user();
        $profile = $user->profile;
        $page    = $request->query('page', 'sell');

        if ($page === 'buy') {
            // 購入した商品：注文を経由してItemを取得
            $items = $user->orders()->with('item')->get()->pluck('item');//pluck('item')でItemモデルのコレクションを取得
        } else {
            // 出品した商品：自分が出品したItem
            $items = $user->items;
        }

        return view('mypage', compact('user', 'profile', 'items', 'page'));
    }

    // プロフィール編集画面
    public function edit()
    {
        $user    = auth()->user();
        $profile = $user->profile;

        return view('profile_edit', compact('user', 'profile'));
    }

    // プロフィール更新処理
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        // Userテーブル（名前）を更新
        $user->update([
            'name' => $request->name,
        ]);

        $profileData = [
            'postcode' => $request->postcode,
            'address'  => $request->address,
            'building' => $request->building,
        ];

        // 画像が送信された場合は storage/app/public に保存
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/profiles', 'public');
            $profileData['image_path'] = $imagePath;
        }

        // profileが未作成の場合は新規作成、存在する場合は更新
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('mypage')->with('message', 'プロフィールを更新しました');
    }
}
