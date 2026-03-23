<?php

namespace Tests\Feature\Item;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_by_name(): void
    {
        $searchItem = Item::factory()->create(['name' => '高級な腕時計']);
        $otherItem = Item::factory()->create(['name' => '中古のノートPC']);

        $response = $this->get('/?keyword=腕時計');

        $response->assertStatus(200);
        $response->assertSee('高級な腕時計');
        $response->assertDontSee('中古のノートPC');
    }

    public function test_search_keyword_is_in_mylist_link(): void
{
    $response = $this->get('/?keyword=腕時計');
    $response->assertStatus(200);

    $response->assertSee('value="腕時計"', false);
    $response->assertSee('keyword=' .rawurlencode('腕時計'));//腕時計をURLエンコードして表示
}

    /*いいね！されていて、検索キーワードが含まれており、さらに他人が出品している商品が表示される*/
    public function test_search_keyword_applied_on_mylist(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $likedMatch = Item::factory()->create(['name' => '高級な腕時計']);
        $likedNoMatch = Item::factory()->create(['name' => '中古のノートPC']);
        Item::factory()->create(['name' => '安い腕時計']); // キーワード一致するが、まだいいねされていない
        $user->likes()->create(['item_id' => $likedMatch->id]);
        $user->likes()->create(['item_id' => $likedNoMatch->id]);

        $response = $this->get('/?tab=mylist&keyword=腕時計');

        $response->assertStatus(200);
        $response->assertSee('高級な腕時計');
        $response->assertDontSee('中古のノートPC');
        $response->assertDontSee('安い腕時計');
    }
}
