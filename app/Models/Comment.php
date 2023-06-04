<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded=[
        'created_at', 'id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function post(){
        return $this->belongsTo(Post::class);
    }
    
    /*public $appends=[
        'human_readable_created_at'
    ];

    public function getHumanReadableCreatedAtAttribute(){
        return $this->created_at->diffForHumans();
    }*/

}
