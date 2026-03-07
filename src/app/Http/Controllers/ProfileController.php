<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // プロフィール編集画面（実装予定）
    public function edit()
    {
        return view('profile.edit');
    }

    // マイページ（実装予定）
    public function mypage()
    {
        return view('mypage');
    }
}
