<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
          [
            'user_id' => 1,
            'name' => '腕時計',
            'price' => 15000,
            'brand_name' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path' => 'images/item-images/watch.jpg',
            'condition' => 'good',
            'is_sold' => true,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'user_id' => 1,
            'name' => 'HDD',
            'price' => 5000,
            'brand_name' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image_path' => 'images/item-images/HardDisk.jpg',
            'condition' => 'no_major_damage',
            'is_sold' => false,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'user_id' => 1,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'brand_name' => null,
            'description' => '新鮮な玉ねぎ3束のセット',
            'image_path' => 'images/item-images/Onion.jpg',
            'condition' => 'slight_damage',
            'is_sold' => false,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'user_id' => 1,
            'name' => '革靴',
            'price' => 4000,
            'brand_name' => null,
            'description' => 'クラシックなデザインの革靴',
            'image_path' => 'images/item-images/LeatherShoes.jpg',
            'condition' => 'poor',
            'is_sold' => false,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'user_id' => 1,
            'name' => 'ノートPC',
            'price' => 45000,
            'brand_name' => null,
            'description' => '高性能なノートパソコン',
            'image_path' => 'images/item-images/NotePC.jpg',
            'condition' => 'good',
            'is_sold' => false,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'user_id' => 2,
            'name' => 'マイク',
            'price' => 8000,
            'brand_name' => null,
            'description' => '高音質のレコーディング用マイク',
            'image_path' => 'images/item-images/Mic.jpg',
            'condition' => 'no_major_damage',
            'is_sold' => false,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'user_id' => 2,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'brand_name' => null,
            'description' => 'おしゃれなショルダーバッグ',
            'image_path' => 'images/item-images/Shoulderbag.jpg',
            'condition' => 'slight_damage',
            'is_sold' => false,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'user_id' => 1,
            'name' => 'タンブラー',
            'price' => 500,
            'brand_name' => null,
            'description' => '使いやすいタンブラー',
            'image_path' => 'images/item-images/Tumbler.jpg',
            'condition' => 'poor',
            'is_sold' => false,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'user_id' => 1,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'brand_name' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image_path' => 'images/item-images/CoffeeGrinder.jpg',
            'condition' => 'good',
            'is_sold' => false,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
          [
            'user_id' => 2,
            'name' => 'メイクセット',
            'price' => 2500,
            'brand_name' => null,
            'description' => '便利なメイクアップセット',
            'image_path' => 'images/item-images/Cosmetics.jpg',
            'condition' => 'no_major_damage',
            'is_sold' => false,
            'sold_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
          ],
        ];
        DB::table('items')->insert($items);
    }
}
