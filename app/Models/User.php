<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'lastName',
        'secondName',
        'birthday',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Отношение "один ко многим" к модели Comment для получения комментариев, созданных данным пользователем.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myComments()
    {
        return $this->hasMany(Comment::class, 'user_creator_id');
    }

    /**
     * Отношение "один ко многим" к модели Comment для получения комментариев, размещенных на странице пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_page_id');
    }
}
