<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TriangleChecker;

class TriangleController extends Controller
{
    public function index()
    {
        return view('triangle.index');
    }

    public function check(Request $request)
    {
        // Validasi input
        $request->validate([
            'a' => 'required|numeric',
            'b' => 'required|numeric',
            'c' => 'required|numeric',
        ]);

        // Panggil logika service yang sudah dibuat sebelumnya
        $checker = new TriangleChecker();
        $result = $checker->check($request->a, $request->b, $request->c);

        // Kembali ke halaman dengan membawa hasil
        return back()->with('result', $result)->withInput();
    }
}
