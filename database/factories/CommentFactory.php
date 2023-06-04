<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Member;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        
        
        $user = Member::all()->random()->id;
        $post=Post::all()->random()->id;
        return [
            'post_id' => $post,
            'user_id' => $user,
            'content' => $this->faker->text(),
        ];
    }
}
