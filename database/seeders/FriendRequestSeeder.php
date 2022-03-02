<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FriendRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 11; $i <= 20; $i++)
        {
            for($j = 1; $j <= 10; $j++)
            {
                \App\Models\FriendRequest::factory()->create(['from_user_id' => $i, 'to_user_id' => $j]);
            }
        }
    }
}
