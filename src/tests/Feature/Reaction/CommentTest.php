<?php

namespace Tests\Feature\Reaction;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_comment_on_item(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create();

        $this->assertSame(0, $item->comments()->count());

        $response = $this->from(route('item.show', $item))
            ->actingAs($user)
            ->post(route('comment.store', $item), [
                'comment' => 'テストコメント',
            ]);

        $response->assertRedirect(route('item.show', $item));

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);
        $this->assertSame(1, $item->fresh()->comments()->count());//fresh()で最新のデータを取得
    }

    public function test_unauthenticated_user_cannot_comment_on_item(): void
    {
        $item = Item::factory()->create();

        $response = $this->post(route('comment.store', $item), [
            'comment' => 'ゲストコメント',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'comment' => 'ゲストコメント',
        ]);
    }

    public function test_empty_comment_shows_validation_message(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create();

        $response = $this->from(route('item.show', $item))
            ->actingAs($user)
            ->post(route('comment.store', $item), ['comment' => '']);

        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);
    }

    public function test_comment_exceeding_255_characters_shows_validation_message(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $item = Item::factory()->create();

        $response = $this->from(route('item.show', $item))
            ->actingAs($user)
            ->post(route('comment.store', $item), [
                'comment' => str_repeat('a', 256),
            ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントは255文字以内で入力してください',
        ]);
    }
}
