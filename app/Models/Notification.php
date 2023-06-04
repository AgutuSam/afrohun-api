<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $guarded=[
        'created_at', 'id'
    ];

    public function member(){
        return $this->belongsTo(Post::class);
    }
}
