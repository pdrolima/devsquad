<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert([
            ['name' => 'Mac'],
            ['name' => 'iPhone'],
            ['name' => 'Watch'],
            ['name' => 'TV']
        ]);
    }
}
