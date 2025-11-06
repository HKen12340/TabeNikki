<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('images')->insert([
            'food_img' => 'path1',
            'shop_img' => 'path1',
            'content_id' => 2
        ]);
        DB::table('images')->insert([
            'food_img' => 'path2',
            'shop_img' => 'path2',
            'content_id' => 3
        ]);
    }
}
