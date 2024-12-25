<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class siswa extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'nis',
        'password',
        'kelas_id',
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

    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }
}
