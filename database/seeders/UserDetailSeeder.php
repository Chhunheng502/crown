<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
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
            \App\Models\UserDetail::factory(1)->create(['user_id' => $i]);
        }
    }
}
