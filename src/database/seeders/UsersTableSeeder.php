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
    }
}
