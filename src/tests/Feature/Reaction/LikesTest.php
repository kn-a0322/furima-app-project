<?php

namespace Tests\Feature\Reaction;

use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_item(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $item = Item::factory()->create();

        $this->actingAs($user)->post(route('like.store', $item));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }


    public function test_user_can_cancel_like_item(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $item = Item::factory()->create();

        $this->actingAs($user)->post(route('like.store', $item));
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user)->delete(route('like.destroy', $item));

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    public function test_liked_icon_changed_color(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $item = Item::factory()->create();

        $notLiked = $this->actingAs($user)->get(route('item.show', $item));
        $notLiked->assertSee('images/icons/heart.png', false);
        $notLiked->assertDontSee('images/icons/heart-pink.png', false);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $liked = $this->actingAs($user)->get(route('item.show', $item));
        $liked->assertSee('images/icons/heart-pink.png', false);
    }
}
