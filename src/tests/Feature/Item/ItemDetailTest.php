<?php

namespace Tests\Feature\Item;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ① 商品詳細に必要な情報が表示される
     * （画像・名前・ブランド・価格・いいね数・コメント数・説明・カテゴリ・状態・コメント欄のユーザー・内容）
     */
    public function test_displays_all_required_item_information(): void
    {
        $seller = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->for($seller)->create([
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'テスト商品の説明文です。',
            'price' => 10000,
            'image_path' => 'images/items/test-detail.jpg',
            'condition' => 'good',
        ]);

        $category = Category::create(['content' => 'テストカテゴリ']);
        $item->categories()->attach($category->id);

        $liker1 = User::factory()->create(['email_verified_at' => now()]);
        $liker2 = User::factory()->create(['email_verified_at' => now()]);
        Like::create(['user_id' => $liker1->id, 'item_id' => $item->id]);
        Like::create(['user_id' => $liker2->id, 'item_id' => $item->id]);

        $commentUser = User::factory()->create([
            'name' => 'テストコメントユーザー',
            'email_verified_at' => now(),
        ]);
        Comment::create([
            'user_id' => $commentUser->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント本文',
        ]);

        $response = $this->get(route('item.show', $item));
        $response->assertStatus(200);

        $response->assertSee('storage/images/items/test-detail.jpg', false);

        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('¥10,000');
        $response->assertSee('（税込）');

        $response->assertSee('2');//いいね数
        $response->assertSee('1');//コメント数
        $response->assertSee('商品説明');
        $response->assertSee('テスト商品の説明文です。');

        $response->assertSee('商品の情報');
        $response->assertSee('カテゴリー');
        $response->assertSee('テストカテゴリ');
        $response->assertSee('商品の状態');
        $response->assertSee('良好'); 

        // コメントの件数・ユーザー名・コメント本文
        $response->assertSee('コメント(1)');
        $response->assertSee('テストコメントユーザー');
        $response->assertSee('テストコメント本文');
    }

    /**
     * ② 複数選択されたカテゴリーがすべて表示される
     */
    public function test_displays_all_selected_categories(): void
    {
        $item = Item::factory()->create();

        $catA = Category::create(['content' => 'カテゴリA']);
        $catB = Category::create(['content' => 'カテゴリB']);
        $catC = Category::create(['content' => 'カテゴリC']);

        $item->categories()->attach([$catA->id, $catB->id, $catC->id]);

        $response = $this->get(route('item.show', $item));

        $response->assertStatus(200);
        $response->assertSee('カテゴリA');
        $response->assertSee('カテゴリB');
        $response->assertSee('カテゴリC');
    }
}
