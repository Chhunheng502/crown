<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++)
        {
            for($j = 1; $j <= 30; $j++)
            {
                \App\Models\Like::factory()->create(['user_id' => $i, 'post_id' => $j]);
            }
        }

        for($i = 10; $i <= 20; $i++)
        {
            for($j = 1; $j <= 10; $j++)
            {
                \App\Models\Like::factory()->create(['user_id' => $i, 'share_id' => $j]);
            }
        }
    }
}
