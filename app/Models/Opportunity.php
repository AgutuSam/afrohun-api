<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;
    protected $guarded=[
        'created_at', 'id'
    ];
    protected $attributes = [
        //'registration_date' => null,
        'verified' => 0,
    ];
}
