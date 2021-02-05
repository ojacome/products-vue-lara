<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $categories = Category::factory()->count(10)->create();

        $categories->each( function( $category ){
                        
            $products = Product::factory()->count(5)->make();    
            $category->products()->saveMany($products);
        });
    }
}
