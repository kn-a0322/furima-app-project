<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Item::create() でEloquentを使い、attach() でカテゴリーを紐づける

        $item1 = Item::create([
            'user_id'     => 1,
            'name'        => '腕時計',
            'price'       => 15000,
            'brand_name'  => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path'  => 'images/items/watch.jpg',
            'condition'   => 'good',
            'is_sold'     => true,
        ]);
        $item1->categories()->attach([1, 12]); // ファッション、アクセサリー

        $item2 = Item::create([
            'user_id'     => 1,
            'name'        => 'HDD',
            'price'       => 5000,
            'brand_name'  => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image_path'  => 'images/items/HardDisk.jpg',
            'condition'   => 'no_major_damage',
            'is_sold'     => false,
        ]);
        $item2->categories()->attach([2]); // 家電

        $item3 = Item::create([
            'user_id'     => 1,
            'name'        => '玉ねぎ3束',
            'price'       => 300,
            'brand_name'  => null,
            'description' => '新鮮な玉ねぎ3束のセット',
            'image_path'  => 'images/items/Onion.jpg',
            'condition'   => 'slight_damage',
            'is_sold'     => false,
        ]);
        $item3->categories()->attach([10]); // キッチン

        $item4 = Item::create([
            'user_id'     => 1,
            'name'        => '革靴',
            'price'       => 4000,
            'brand_name'  => null,
            'description' => 'クラシックなデザインの革靴',
            'image_path'  => 'images/items/LeatherShoes.jpg',
            'condition'   => 'poor',
            'is_sold'     => false,
        ]);
        $item4->categories()->attach([1, 5]); // ファッション、メンズ

        $item5 = Item::create([
            'user_id'     => 1,
            'name'        => 'ノートPC',
            'price'       => 45000,
            'brand_name'  => null,
            'description' => '高性能なノートパソコン',
            'image_path'  => 'images/items/NotePC.jpg',
            'condition'   => 'good',
            'is_sold'     => false,
        ]);
        $item5->categories()->attach([2]); // 家電

        $item6 = Item::create([
            'user_id'     => 2,
            'name'        => 'マイク',
            'price'       => 8000,
            'brand_name'  => null,
            'description' => '高音質のレコーディング用マイク',
            'image_path'  => 'images/items/Mic.jpg',
            'condition'   => 'no_major_damage',
            'is_sold'     => false,
        ]);
        $item6->categories()->attach([2]); // 家電

        $item7 = Item::create([
            'user_id'     => 2,
            'name'        => 'ショルダーバッグ',
            'price'       => 3500,
            'brand_name'  => null,
            'description' => 'おしゃれなショルダーバッグ',
            'image_path'  => 'images/items/Shoulderbag.jpg',
            'condition'   => 'slight_damage',
            'is_sold'     => false,
        ]);
        $item7->categories()->attach([1, 4]); // ファッション、レディース

        $item8 = Item::create([
            'user_id'     => 1,
            'name'        => 'タンブラー',
            'price'       => 500,
            'brand_name'  => null,
            'description' => '使いやすいタンブラー',
            'image_path'  => 'images/items/Tumbler.jpg',
            'condition'   => 'poor',
            'is_sold'     => false,
        ]);
        $item8->categories()->attach([3, 10]); // インテリア、キッチン

        $item9 = Item::create([
            'user_id'     => 1,
            'name'        => 'コーヒーミル',
            'price'       => 4000,
            'brand_name'  => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image_path'  => 'images/items/CoffeeGrinder.jpg',
            'condition'   => 'good',
            'is_sold'     => false,
        ]);
        $item9->categories()->attach([3, 10]); // インテリア、キッチン

        $item10 = Item::create([
            'user_id'     => 2,
            'name'        => 'メイクセット',
            'price'       => 2500,
            'brand_name'  => null,
            'description' => '便利なメイクアップセット',
            'image_path'  => 'images/items/Cosmetics.jpg',
            'condition'   => 'no_major_damage',
            'is_sold'     => false,
        ]);
        $item10->categories()->attach([6, 4]); // コスメ、レディース
    }
}
