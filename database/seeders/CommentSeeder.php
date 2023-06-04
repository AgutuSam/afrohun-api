<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Member;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 10;
        $comments = Comment::factory()->count($count)->make();

        $users = Member::all();
        $posts= Post::all();


        $comments->each(function($comment) use (&$posts, &$users){
            $comment['post_id'] = $posts->random()->id;
            $comment['user_id'] = $users->random()->id;
            Comment::create($comment->toArray());
            $this->command->info("OK => Created post: ".$comment->content);
        });

    }
}
