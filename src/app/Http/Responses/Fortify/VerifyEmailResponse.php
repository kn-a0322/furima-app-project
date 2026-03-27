<?php

namespace App\Http\Responses\Fortify;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;
use Laravel\Fortify\Fortify;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmailResponse implements VerifyEmailResponseContract
{
    /**
     * メール認証完了後、プロフィール未作成なら設定画面へ。それ以外はホームへ。
     */
    public function toResponse($request): Response
    {
        if ($request->wantsJson()) {
            return new JsonResponse('', 204);
        }

        $user = $request->user();
        if ($user && $user->profile === null) {
            return redirect()->route('profile.edit');
        }

        $path = Fortify::redirects('email-verification', config('fortify.home'));

        return redirect()->to($path.'?verified=1');
    }
}
