<?php

namespace App\Http\Controllers;

use App\Mail\MagicLoginMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AuthController extends Controller
{
    /** Tampilkan halaman form input email */
    public function showLogin()
    {
        return Inertia::render('Auth/Login');
    }

    /** Proses input email, generate token, dan kirim email */
    public function sendMagicLink(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $validated['email'])->first();

        // Selalu return pesan yang sama demi keamanan (mencegah email enumeration)
        if ($user && $user->is_active) {
            $token = Str::random(64);
            
            $user->update([
                'login_token' => $token,
                'login_token_expires_at' => now()->addMinutes(15), // Token berlaku 15 menit
            ]);

            Mail::to($user->email)->send(new MagicLoginMail($user, $token));
        }

        return redirect()->back()->with('success', 'Jika email Anda terdaftar dan aktif, kami telah mengirimkan tautan masuk ke email tersebut.');
    }

    /** Verifikasi token dari klik email */
    public function verifyLogin(string $token)
    {
        $user = User::where('login_token', $token)
            ->where('login_token_expires_at', '>', now())
            ->first();

        if (! $user || ! $user->is_active) {
            return redirect('/login')->with('error', 'Tautan masuk tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.');
        }

        // Login user
        auth()->login($user);

        // Hapus token dan update last login
        $user->update([
            'login_token' => null,
            'login_token_expires_at' => null,
            'last_login_at' => now(),
        ]);

        return redirect('/')->with('success', 'Selamat datang kembali, ' . $user->name . '!');
    }
}
