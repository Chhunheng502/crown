<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 5; $i++)
        {
            \App\Models\Chat::factory(1)->create(['user_id' => $i, 'user2_id' => 5 + $i]);
        }
    }
}
