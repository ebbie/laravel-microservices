<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()->count(25)->create();
    }
}
