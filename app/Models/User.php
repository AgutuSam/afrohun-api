<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'firstname',
        'lastname',
        'type',
        'profile_picture',
        'approved',
        'institution',
        'career',
        'age',
        'location',
        'school',
        'faculty',
        'grad_year',
        'course',
        'bio',
        'interests',
        'speciality',
        'organisation',
        'availability',
        'title',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        //'registration_date' => null,
        // 'approved' => 1,
        'type'=>'Alumni',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function markEmailAsVerified()
    {
        $this->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }

    public function messages(): HasMany
    {
    return $this->hasMany(Message::class);
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Groupz::class, 'group_membership', 'user_id', 'groupz_id');
    }
}
