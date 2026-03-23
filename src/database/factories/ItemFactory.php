<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->words(3, true),
            'price' => fake()->numberBetween(100, 99999),
            'description' => fake()->sentence(),
            'image_path' => 'images/items/watch.jpg',
            'condition' => 'good',
            'is_sold' => false,
        ];
    }
}
