<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FriendshipSeeder extends Seeder
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
                \App\Models\Friendship::factory()->create(['user_id' => $i, 'user2_id' => $j]);
            }
        }
    }
}
