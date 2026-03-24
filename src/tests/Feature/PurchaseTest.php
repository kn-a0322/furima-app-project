<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Order;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchase_redirects_to_profile_edit_without_profile(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get(route('purchase', ['item_id' => $item->id]));

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('message', 'プロフィールを登録してください');
    }

    public function test_purchase_page_loads_correctly(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::create(['user_id' => $user->id]);
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'price' => 10000,
        ]);

        $response = $this->actingAs($user)->get(route('purchase', ['item_id' => $item->id]));
        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('10,000');
    }

    public function test_guest_cannot_access_purchase_page(): void
    {
        $item = Item::factory()->create();
        $response = $this->get(route('purchase', ['item_id' => $item->id]));
        $response->assertRedirect(route('login'));
    }

    //ID11: 支払い方法を選択
    public function test_user_can_select_payment_method(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::create(['user_id' => $user->id]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get(route('purchase', ['item_id' => $item->id, 'payment_method' => 'credit_card']));
        $response->assertStatus(200);
        $response->assertSee('カード支払い');
    }

    //ID10:購入完了とSold表示
    public function test_user_can_purchase_item(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::create(['user_id' => $user->id]);
        $item = Item::factory()->create(['price' => 10000]);

        //Stripeでの支払い確定後のセッションデータ
        session([
           'pending_order' => [
            'payment_method' => 'credit_card',
            'shipping_postcode' => '123-4567',
            'shipping_address' => '東京都千代田区永田町1-7-1',
            'shipping_building' => '永田町ビル10F',
            ]
        ]);

        $response = $this->actingAs($user)
        ->get(route('purchase.success', ['item_id' => $item->id]));

        $response->assertRedirect(route('item.index'));

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);

        $response = $this->get(route('item.index'));
        $response->assertSee('Sold');
    }

    public function test_purchased_item_is_listed_in_maypage(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::create(['user_id' => $user->id]);
        $item = Item::factory()->create(['name' => 'マイページ表示用テスト商品']);

        //Stripeでの支払い確定後のセッションデータ
        session([
            'pending_order' => [
                'payment_method' => 'credit_card',
                'shipping_postcode' => '123-1234',
                'shipping_address' => 'テストアドレス',
                'shipping_building' => 'テストビル',
            ]
        ]);
        $this->actingAs($user)->get(route('purchase.success', ['item_id' => $item->id]));

        $response = $this->actingAs($user)->get(route('mypage', ['page' => 'buy']));

        $response->assertStatus(200);
        $response->assertSee('マイページ表示用テスト商品');
    }

    //ID:12 配送先住所変更の反映
    public function test_changed_shipping_address_is_reflected_in_purchase_page(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::create(['user_id' => $user->id]);
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('purchase.address.update', ['item_id' => $item->id]), [
            'shipping_postcode' => '111-1111',
            'shipping_address' => '変更後テストアドレス',
            'shipping_building' => '変更後テストビル',
        ]);

        $response = $this->get(route('purchase', $item->id));
        $response->assertSee('111-1111');
        $response->assertSee('変更後テストアドレス');
        $response->assertSee('変更後テストビル');
    }

    //ID12: 購入した商品に送付先住所が紐づいて登録される
    public function test_purchased_item_is_registered_with_shipping_address(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Profile::create(['user_id' => $user->id]);
        $item = Item::factory()->create();

        session(['pending_order' => [
            'payment_method' => 'credit_card',
            'shipping_postcode' => '222-2222',
            'shipping_address' => '変更後テストアドレス222',
            'shipping_building' => '変更後テストビル222',
        ]]);

        $this->actingAs($user)->get(route('purchase.success', ['item_id' => $item->id]));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_postcode' => '222-2222',
            'shipping_address' => '変更後テストアドレス222',
            'shipping_building' => '変更後テストビル222',
        ]);
    }
}
