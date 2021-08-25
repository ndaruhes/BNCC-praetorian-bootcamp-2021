<?php

namespace Database\Seeders;

use App\Models\Blog;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 9; $i++) {
            Blog::insert([
                'judul' => $faker->realText($maxNbChars = 20, $indexSize = 2),
                'content' => $faker->realText($maxNbChars = 1000, $indexSize = 2),
                'cover' => $faker->imageUrl(800, 600, 'cats'),
                'user_id' => $faker->biasedNumberBetween($min = 1, $max = 10),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
    }
}
