<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded=[
        'created_at', 'id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function member(){
        return $this->belongsTo(Member::class);
    }
    public function like()
    {
        return $this->hasMany(Like::class);
    }
}
