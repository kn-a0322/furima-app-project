<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use App\Models\User;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    //メールアドレスが認証されているか
    public function test_email_varification_works(): void
    {
        Notification::fake();//通知をフェイクにする

        $response = $this->post(route('register.store'), [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('verification.notice'));
        
        //登録されたユーザーを取得
        $user = User::where('email', 'test@example.com')->first();
        
        //メール認証URLを生成
        $varificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($varificationUrl);

        $response->assertRedirect(route('profile.edit'));
        //DB上でメール認証日時が更新されているか
        $this->assertNotNull($user->fresh()->email_verified_at);
        
    }
}
