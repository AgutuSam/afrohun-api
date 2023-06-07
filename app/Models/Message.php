<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

/**
 * Fields that are mass assignable
 *
 * @var array
 */
protected $fillable = ['message', 'receiver_id'];


public function user(): BelongsTo
{
  return $this->belongsTo(User::class);
}


}
