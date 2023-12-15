<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roles')->insert([
            [
                'RoleName' => 'User',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'RoleName' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'RoleName' => 'Moderator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more roles as needed
        ]);
    }
}
