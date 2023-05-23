<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('fa_IR');
        foreach (range(1, 30) as $item) {
            Comment::create([
                'body' => $faker->text(250),
                'is_pined' => $faker->boolean(),
                'likes' => $faker->numberBetween(0, 100),
            ]);
        }
    }
}
