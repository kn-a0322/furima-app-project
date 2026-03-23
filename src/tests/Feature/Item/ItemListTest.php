<?php

namespace Tests\Feature\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;


class ItemListTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_items_display(): void
    {
        Item::factory()->count(10)->create();
        $response = $this->get('/');
        
        $items = Item::all();
        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_sold_items_displayed_sold_label(): void
    {
        $item = Item::factory()->create(['is_sold' => true]);
        $response = $this->get('/');
        $response->assertSee('Sold');
    }

    public function test_owned_items_not_displayed(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $myItems = Item::factory()->count(3)->create(['user_id' => $user->id]);
        $otherItems = Item::factory()->count(3)->create();

        $response = $this->get('/');
        foreach ($myItems as $item) {
            $response->assertDontSee($item->name);
        }
        foreach ($otherItems as $item) {
            $response->assertSee($item->name);
        }
    }

    public function test_liked_items_displayed_in_mylist(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $likedItem = Item::factory()->create();
        $noLikedItem = Item::factory()->create();
        $user->likes()->create(['item_id' => $likedItem->id]);

        $response = $this->get('/?tab=mylist');
        $response->assertSee($likedItem->name);
        $response->assertDontSee($noLikedItem->name);
    }

    public function test_sold_items_displayed_sold_label_in_mylist(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $soldItem = Item::factory()->create([
            'is_sold' => true,
            'name' => '購入済みいいね商品テスト',
        ]);
        $user->likes()->create(['item_id' => $soldItem->id]);

        $response = $this->get('/?tab=mylist');
        $response->assertSee('購入済みいいね商品テスト');
        $response->assertSee('Sold');
    }

    public function test_mylist_shows_no_items_before_login(): void
    {
        Item::factory()->create(['name' => '未ログインでは出ない商品']);

        $response = $this->get('/?tab=mylist');

        $response->assertOk();
        $response->assertDontSee('未ログインでは出ない商品');
    }


}
