<?php

namespace Database\Seeders;

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
        \App\Models\Comment::factory(10)->create(['post_id' => null]);
        \App\Models\Comment::factory(10)->create(['share_id' => null]);
    }
}
