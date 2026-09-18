@component('mail::message')
# Halo, {{ $name }}!

Klik tombol di bawah ini untuk masuk ke akun **Sistem Inventaris IT DAOP 5** Anda.

@component('mail::button', ['url' => $loginUrl, 'color' => 'blue'])
Masuk ke Sistem
@endcomponent

> **Penting:** Tautan ini hanya berlaku selama **15 menit** dan hanya dapat digunakan satu kali.

Jika Anda tidak merasa meminta tautan ini, abaikan saja email ini.

Salam,  
**Tim IT DAOP 5**
@endcomponent
