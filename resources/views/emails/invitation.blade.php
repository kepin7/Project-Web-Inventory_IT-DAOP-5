@component('mail::message')
# Halo, {{ $name }}!

Anda telah diundang untuk bergabung sebagai **Admin** di **Sistem Inventaris IT DAOP 5**.

Klik tombol di bawah ini untuk menerima undangan dan mengaktifkan akun Anda:

@component('mail::button', ['url' => $invitationUrl, 'color' => 'blue'])
Terima Undangan
@endcomponent

> **Penting:** Tautan ini hanya berlaku hingga **{{ $expiresAt }}** dan hanya dapat digunakan satu kali.

Jika Anda tidak merasa mengharapkan undangan ini, abaikan email ini.

Salam,
**Tim IT DAOP 5**
@endcomponent
