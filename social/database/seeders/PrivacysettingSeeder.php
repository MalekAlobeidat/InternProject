<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrivacysettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('privacysettings')->insert([
            [
                'PrivacyName' => 'Friends Only',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'PrivacyName' => 'Everyone',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more privacy settings as needed
        ]);
    }
}
