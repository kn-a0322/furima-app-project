<?php

namespace App\Http\Responses\Fortify;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Symfony\Component\HttpFoundation\Response;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * 会員登録直後はメール認証案内へ。
     */
    public function toResponse($request): Response
    {
        return $request->wantsJson()
            ? response()->json('', 201)
            : redirect()->route('verification.notice');
    }
}
