<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validasi data yang diterima dari request
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Coba melakukan proses autentikasi
        if (Auth::attempt($request->only('username', 'password'))) {
            // Autentikasi berhasil
            return response()->json(['message' => 'Login successful', 'user' => Auth::user()], 200);
        } else {
            // Autentikasi gagal
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}
