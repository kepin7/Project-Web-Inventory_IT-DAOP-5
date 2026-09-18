<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $invitations = Invitation::with('invitedBy')
            ->whereNull('accepted_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($inv) {
                return [
                    'id' => $inv->id,
                    'name' => $inv->name,
                    'email' => $inv->email,
                    'role' => $inv->role,
                    'status' => $inv->status,
                    'expires_at' => $inv->expires_at,
                    'created_at' => $inv->created_at,
                    'invited_by' => $inv->invitedBy?->name,
                ];
            });

        return Inertia::render('Management/Users/Index', [
            'users' => $users,
            'invitations' => $invitations,
        ]);
    }

    public function invite(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:invitations,email',
        ]);

        $token = Str::random(64);

        $invitation = Invitation::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'token' => $token,
            'role' => 'admin',
            'invited_by' => auth()->id(),
            'expires_at' => now()->addDays(7),
        ]);

        Mail::to($validated['email'])->send(new InvitationMail($invitation));

        return redirect()->back()->with('success', 'Undangan berhasil dikirim ke '.$validated['email']);
    }

    public function toggleActive(User $user)
    {
        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Super Admin tidak dapat dinonaktifkan.');
        }

        $user->update(['is_active' => ! $user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Pengguna {$user->name} berhasil {$status}.");
    }

    public function cancelInvitation(Invitation $invitation)
    {
        $invitation->delete();

        return redirect()->back()->with('success', 'Undangan berhasil dibatalkan.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,super_admin',
        ]);

        if ($user->isSuperAdmin() && $validated['role'] !== 'super_admin') {
            $superAdminsCount = User::where('role', 'super_admin')->count();
            if ($superAdminsCount <= 1) {
                return redirect()->back()->with('error', 'Gagal: Minimal harus ada 1 Super Admin di sistem.');
            }
        }

        $user->update($validated);

        return redirect()->back()->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {
        if ($user->isSuperAdmin()) {
            $superAdminsCount = User::where('role', 'super_admin')->count();
            if ($superAdminsCount <= 1) {
                return redirect()->back()->with('error', 'Gagal: Tidak dapat menghapus satu-satunya Super Admin.');
            }
        }

        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Gagal: Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "Pengguna {$name} berhasil dihapus.");
    }
}
