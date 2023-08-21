<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupz extends Model
{
    use HasFactory;

    protected $table = 'groupz'; // Set the table name to 'groupz' as per your requirement.

    protected $fillable = ['name', 'group_image','admin_id']; // Add other fillable fields if required.

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_membership', 'groupz_id', 'user_id');
    }


}
