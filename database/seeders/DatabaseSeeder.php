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
        $this->call(UserDetailSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(ShareSeeder::class);
        $this->call(LikeSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(CommentReplySeeder::class);
        $this->call(FriendshipSeeder::class);
        $this->call(FriendRequestSeeder::class);
        $this->call(ChatSeeder::class);
        $this->call(PrivateMsgSeeder::class);
    }
}
