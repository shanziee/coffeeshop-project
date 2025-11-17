<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// PENTING: Gunakan ini agar Admin bisa login
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Ganti 'Model' menjadi 'Authenticatable'
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Beri tahu model ini untuk menggunakan 'guard' admin
    protected $guard = 'admin';

    // Beri tahu model ini nama primary key Anda
    protected $primaryKey = 'adminID';

    /**
     * Atribut yang boleh diisi.
     * (Username & Password)
     */
    protected $fillable = [
        'username',
        'password',
    ];

    /**
     * Atribut yang harus disembunyikan.
     * (Password)
     */
    protected $hidden = [
        'password',
    ];
}
