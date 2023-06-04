<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $count = 100;
        $posts = Post::factory()->count($count)->make();

        $users = Member::all();

        $posts->each(function($post) use (&$users){
            $post['user_id'] = $users->random()->id;
            Post::create($post->toArray());
            $this->command->info("OK => Created post: ".$post->description);
        });
    }
}
