<?php

use Illuminate\Database\Seeder;
use Illuminate\Dadabase\Eloquent\Model;
use CodeCommerce\product;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();
        
        $faker = Faker::create();
        
        foreach(range(1,40) as $i){
            Product::create([
                'name' => $faker->word(),
                'description' => $faker->sentence(),
                'price' => $faker->randomNumber(2),
                'category_id'=>$faker->NumberBetween(1,15)
            ]);
        }
    }
}
