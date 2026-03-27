<?php

namespace App\Http\Responses\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    /**
     * プロフィール未作成の初回ログインはプロフィール設定へ。
     */
    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return response()->json(['two_factor' => false]);
        }

        $user = $request->user();
        if ($user && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        if ($user && $user->profile === null) {
            return redirect()->to(route('profile.edit'));
        }

        return redirect()->intended(Fortify::redirects('login'));
    }
}
