<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Text;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory()
            ->has(Text::factory()->count(5))
            ->create();
    }
}