<?php

use Illuminate\Database\Seeder;
use Illuminate\Dadabase\Eloquent\Model;
use CodeCommerce\category;
use Faker\Factory as Faker;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();
        
        $faker = Faker::create();
        
        foreach(range(1,15) as $i){
            Category::create([
                'name' => $faker->word(),
                'description' => $faker->sentence()
            ]);
        }
    }
}
