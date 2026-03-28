<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => '山田太郎',
                'email' => 'test1@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'id' => 2,
                'name' => '山田花子',
                'email' => 'test2@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];
        DB::table('users')->insert($users);

        DB::table('profiles')->insert([
            [
                'user_id' => 1, // 山田太郎
                'postcode' => '123-4567',
                'address' => '神奈川県相模原市南区',
                'building' => 'ハイツ101',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // 山田花子
                'postcode' => '987-6543',
                'address' => '神奈川県相模原市中央区',
                'building' => 'ハイツ202',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
