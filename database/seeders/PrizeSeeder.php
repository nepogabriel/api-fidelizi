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
                'name' => 'Suco de Laranja',
                'points' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '10% de desconto',
                'points' => 10,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Almoço especial',
                'points' => 20,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('prizes')->insert($prizes);
    }
}
