<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type=$this->faker->randomElement(['I', 'B']);
        $name= $type =='I' ? $this->faker->firstname(): $this->faker->company();
        return [
            'firstname'=> $name,
            'lastname'=> $this->faker->lastname(),
            'type'=> $type,
            'email'=> $this->faker->email(),
            'profile_picture'=> $this->faker->url(),
            'active'=> $this->faker->boolean(),
            'registration_date'=> now(),
            'password'=> $this->faker->password()
        ];
    }
}
