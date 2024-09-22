<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Laptop X',
                'price' => 12000000,
                'stock' => 15,
                'sold' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Smartphone Y',
                'price' => 7000000,
                'stock' => 30,
                'sold' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
