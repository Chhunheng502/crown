<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PrivateMsgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 5; $i++)
        {
            for($j = $i + 1; $j <= 5; $j++)
            {
                \App\Models\PrivateMsg::factory(1)->create(['chat_id' => $i, 'from_user_id' => $i, 'to_user_id' => $j]);
            }
        }
    }
}
