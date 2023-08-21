<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTable extends Model
{
    use HasFactory;

    protected $table = 'data_table'; // Name of the database table
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'institution',
        'job_title',
        'participant_type',
        'age',
        'discipline',
        'role_in_activity',
        'country',
        'remarks',
        'sheet_name',
    ];
}
