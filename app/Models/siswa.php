<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class siswa extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'nis',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
