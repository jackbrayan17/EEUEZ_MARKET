<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Electronics'],
            ['name' => 'Books'],
            ['name' => 'Clothing'],
            ['name' => 'Home & Kitchen'],
            ['name' => 'Sports'],
            ['name' => 'Toys & Games'],
            ['name' => 'Health & Beauty'],
            ['name' => 'Automotive'],
            ['name' => 'Garden'],
            ['name' => 'Office Supplies'],
            ['name' => 'Pet Supplies'],
            ['name' => 'Jewelry'],
            ['name' => 'Movies & Music'],
            ['name' => 'Food & Beverages'],
            ['name' => 'Travel & Leisure'],
            ['name' => 'Fitness Equipment'],
        ]);
    }
}