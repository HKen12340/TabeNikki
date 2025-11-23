<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contents')->insert([
            'food_name' => 'サンマーメン',
            'shop_name' => '龍王',
            'price' => 650,
            'place' => '横浜駅',
            'thoughts' => '美味しい',
            'user_id' => 7
        ]);

        DB::table('contents')->insert([
            'food_name' => 'カレーライス',
            'shop_name' => '花壇',
            'price' => 700,
            'place' => '桜木町',
            'thoughts' => 'シンプルなカレーライス',
            'user_id' => 7
        ]);
    }
}
