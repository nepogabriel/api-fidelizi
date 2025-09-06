<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrizeSeeder extends Seeder
{
    public function run(): void
    {
        $prizes = [
            [
                'name' => 'Orange Juice',
                'points' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '10% Discount',
                'points' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Special Lunch',
                'points' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('prizes')->insert($prizes);
    }
}
