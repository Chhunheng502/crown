<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 10; $i++)
        {
            for($j = $i + 1; $j <= 10; $j++)
            {
                \App\Models\CommentReply::factory()->create(['from_user_id' => $i, 'to_user_id' => $j]);
            }
        }
    }
}
