<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Order;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    //マイページでプロフィール編集ページに必要な情報が表示されているか
    public function test_profile_page_shows_required_information(): void
    {
        $user = User::factory()->create(['name' => 'テストユーザー']);

        Profile::create([
            'user_id' => $user->id,
            'name' => 'テストユーザー',
            'postcode' => '123-4567',
            'address' => '神奈川県相模原市1-1-1',
            'building' => 'テストビル111',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('神奈川県相模原市1-1-1');
        $response->assertSee('テストビル111');
    }
    //プロフィール編集ページでプロフィール画像の初期値が表示されているか
    public function test_profile_edit_page_shows_initial_profile_image(): void
    {
        $user = User::factory()->create();
        $profile = Profile::create([
            'user_id' => $user->id,
            'image_path' => 'profile_images/test.jpg',
            'username' => 'テストユーザー',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));
    
        $response->assertSee('profile_images/test.jpg');
    }

    //マイページで必要な情報(出品一覧、購入一覧)が表示されているか
    public function test_mypage_shows_user_information_and_items(): void
    {
        $user = User::factory()->create(['name' => 'テストユーザー']);
        Profile::create(['user_id' => $user->id]);

        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品したテスト商品'
        ]);

        $buyItem = Item::factory()->create(['name' => '購入したテスト商品']);
        Order::create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
            'price' => 10000,
            'payment_method' => 'credit_card',
            'shipping_postcode' => '123-4567',
            'shipping_address' => '神奈川県相模原市1-1-1',
            'shipping_building' => 'テストビル111',
        ]);

        $response = $this->actingAs($user)->get(route('mypage'));

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('出品したテスト商品');
        $response = $this->get(route('mypage', ['page' => 'buy']));
        $response->assertSee('購入したテスト商品');

    }

    //更新した内容が次回の編集画面で初期値になる
    public function test_updated_content_is_initial_value_on_next_edit_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->patch(route('profile.update'), [
            'name' => '更新後テストユーザー',
            'postcode' => '333-3333',
            'address' => '更新後テストアドレス'
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));
        $response->assertSee('更新後テストユーザー');
        $response->assertSee('333-3333');
        $response->assertSee('更新後テストアドレス');
    }
}
