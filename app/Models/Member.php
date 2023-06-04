<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable=[
        'firstname',
        'lastname',
        'type',
        'profile_picture',
        'password',
        'email',
        'active',
        'expertise',
        'experience',
        'innovations',
        'links',
        'certs', 
        'address',
        'latitude',
        'longitude'
    ];
    protected $attributes = [
        //'registration_date' => null,
        'active' => 0,
        'type'=>'i',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function like()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
}
