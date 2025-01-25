<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123'),
                'is_vendor' => 0,
                'phone' => '',
            ],
            [
                'name' => 'member',
                'email' => 'member@gmail.com',
                'password' => Hash::make('123'),
                'is_vendor' => 0,
                'phone' => '',
            ],

        ];
        DB::table('users')->insert($data);
    }
}
