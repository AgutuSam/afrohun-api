<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 99;
        
        
        $users = User::factory($count)->make();
        // dd($users->first());
        
        $users->each(function($user) {
            User::create($user->toArray());
            $this->command->info("OK => Created user: ".$user->name);
        });
    }
}
