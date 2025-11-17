<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan halaman menu utama.
     */
    public function showMenu()
    {
        // Ini akan menampilkan file 'resources/views/menu.blade.php'
        return view('menu');
    }
}
