<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Inertia\Inertia;

class InvitationController extends Controller
{
    public function show(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->isAccepted()) {
            return redirect('/')->with('error', 'Tautan undangan ini sudah pernah digunakan.');
        }

        if ($invitation->isExpired()) {
            return redirect('/')->with('error', 'Tautan undangan ini sudah kadaluarsa. Minta Super Admin untuk mengirim ulang.');
        }

        return Inertia::render('Invitation/Accept', [
            'invitation' => [
                'name' => $invitation->name,
                'email' => $invitation->email,
                'token' => $invitation->token,
            ],
        ]);
    }

    public function accept(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->isAccepted() || $invitation->isExpired()) {
            return redirect('/')->with('error', 'Tautan undangan tidak valid atau sudah kadaluarsa.');
        }

        $user = User::create([
            'name' => $invitation->name,
            'email' => $invitation->email,
            'role' => $invitation->role,
            'is_active' => true,
        ]);

        $invitation->update(['accepted_at' => now()]);

        auth()->login($user);
        $user->update(['last_login_at' => now()]);

        return redirect('/')->with('success', 'Selamat datang, '.$user->name.'! Akun Anda berhasil dibuat.');
    }
}
