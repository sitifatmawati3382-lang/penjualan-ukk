<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan model User diimpor

class LoginController extends Controller
{
    public function form_login(){
        return view('autentikasi.login');
    }

    /**
     * Memproses permintaan login dengan password non-enkripsi.
     */
    public function proses_login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('username', $credentials['username'])->first();

        // DEBUGGING: Cek apakah user ditemukan
        //dd($user);

        if ($user && $user->password === $credentials['password']) {
            // DEBUGGING: Kode ini akan dieksekusi jika password cocok
            // dd('Login berhasil!');
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // DEBUGGING: Kode ini akan dieksekusi jika login gagal
        //dd('Login gagal!');
        
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}