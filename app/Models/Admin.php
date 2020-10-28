<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * Attributes that are Mass Assignable
     *
     * @var string[]
     */
    protected $fillable = [ 'name', 'email', 'password' ];

    /**
     * Attributes that are hidden for arrays
     *
     * @var string[]
     */
    protected $hidden = [ 'password', 'remember_token' ];

    /**
     * Attributes that are cast to native types
     *
     * @var string[]
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
