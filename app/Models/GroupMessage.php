<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    use HasFactory;

    protected $fillable = ['groupz_id', 'user_id', 'content'];

    public function groupz()
    {
        return $this->belongsTo(Groupz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
