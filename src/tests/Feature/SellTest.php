<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;


class SellTest extends TestCase
{
    use RefreshDatabase;
    
    //出品ページにて必要な情報が保存されているか
    public function test_required_information_is_saved_when_selling_item(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['email_verified_at' => now()]);
        $category = Category::create(['content' => 'テストカテゴリ']);

        $response = $this->actingAs($user)->post(route('item.store'), [
            'category_ids' => [$category->id],
            'condition' => 'good',
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'テスト商品の説明',
            'price' => 10000,
            'image' => UploadedFile::fake()->createWithContent(
                'test.jpg',
                file_get_contents(__DIR__ . '/../fixtures/minimal.jpg')
            ),
        ]);

        $response->assertRedirect(route('item.index'));

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'condition' => 'good',
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'テスト商品の説明',
            'price' => 10000,
        ]);

        $item = Item::where('name', 'テスト商品')->first();
        $this->assertTrue($item->categories->contains($category->id));
    }
}
