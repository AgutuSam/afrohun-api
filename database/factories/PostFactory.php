<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;
    
    public function definition()
    {
        $user = Member::where('id')->get();
        return [
            'user_id' => $user,
            'content' => $this->faker->text(),
            'description' =>  $this->faker->sentence(),
        ];
    }
}
