<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(UserDetailSeeder::class);

        $this->call(PostSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(FriendshipSeeder::class);
        $this->call(ChatSeeder::class);
        $this->call(PrivateMsgSeeder::class);
    }
}
