# Sistem Inventaris IT DAOP 5 Purwokerto

Sistem Inventaris IT DAOP 5 adalah aplikasi berbasis web modern yang dibangun dengan arsitektur **Laravel + Inertia.js + Vue.js** untuk mengelola data *spare part*, melacak pergerakan stok, dan memberikan kemampuan pencatatan otomatis menggunakan AI (Artificial Intelligence) dari Google Gemini.

## Fitur Utama
- ✨ **Dashboard & Notifikasi**: Pemantauan statistik, stok menipis, dan log aktivitas real-time.
- 📦 **Manajemen Spare Part**: Manajemen barang dengan kategori dan lokasi gudang.
- 🔄 **Pergerakan Stok (In/Out)**: Pelacakan riwayat barang masuk/keluar beserta kondisi.
- 🔐 **Autentikasi Magic Link**: Login super aman tanpa password.
- 🤖 **Ekstraksi AI (Gemini)**: Upload foto barang/barcode, biarkan AI mengetikkan detail (Merk, Tipe, SN) secara otomatis dengan sistem *Load Balancing* multi-API Key.

---

## Prasyarat Instalasi (Persiapan Lingkungan)
Pastikan komputer / server Anda telah terinstal perangkat lunak berikut:
1. **PHP** (Versi 8.3 atau yang lebih baru)
2. **Composer**
3. **Node.js** dan **NPM**
4. **MySQL** / **MariaDB** (melalui XAMPP / Laragon / instalasi langsung)
5. Akun **Google (Gmail)** (Untuk pengaturan SMTP Email dan mendapatkan API Key Gemini)

---

## Langkah-Langkah Setup (Instalasi)

### 1. Kloning / Ekstrak Proyek
Buka terminal (CMD / Git Bash) di folder tempat Anda ingin menyimpan proyek, lalu jalankan:
```bash
git clone <url-repository-anda>
cd inventory_DAOP5
```
*(Lewati langkah ini jika Anda sudah memiliki folder proyek dari file `.zip`)*

### 2. Instalasi Dependensi (Backend & Frontend)
Instal semua modul PHP dan *package* JavaScript yang dibutuhkan:
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Gandakan file `.env.example` dan ubah namanya menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` yang baru dibuat di teks editor Anda (seperti VS Code) lalu atur variabel berikut:

**A. Pengaturan Database (Sesuaikan dengan MySQL Anda)**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_daop5
DB_USERNAME=root
DB_PASSWORD=
```
*(Pastikan Anda telah membuat database kosong bernama `inventory_daop5` di phpMyAdmin atau aplikasi sejenis).*

**B. Pengaturan Email (Wajib untuk Magic Link)**
Gunakan [App Password Gmail](https://myaccount.google.com/apppasswords) Anda.
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="email_anda@gmail.com"
MAIL_PASSWORD="app_password_anda_tanpa_spasi"
MAIL_FROM_ADDRESS="email_anda@gmail.com"
```

**C. Pengaturan Gemini AI (Untuk Fitur Scan Otomatis)**
Dapatkan API Key secara gratis di [Google AI Studio](https://aistudio.google.com/). Anda bisa memasukkan hingga 5 API Key (dipisahkan koma tanpa spasi) untuk mencegah limit token.
```env
GEMINI_API_KEYS="API_KEY_1,API_KEY_2,API_KEY_3"
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Migrasi dan Seeding Database
Jalankan perintah ini untuk membangun tabel *database* dan membuat akun Super Admin otomatis.
```bash
php artisan migrate:fresh --seed
```
*(Akun default: `hizkiakevin8@gmail.com`. Anda bisa mengubahnya di file `database/seeders/DatabaseSeeder.php` jika diperlukan sebelum menjalankan perintah ini).*

### 6. Link Storage (Opsional, untuk fitur upload gambar)
```bash
php artisan storage:link
```

---

## Cara Menjalankan Aplikasi

Anda membutuhkan **2 terminal** yang berjalan secara bersamaan.

**Terminal 1 (Backend - Laravel):**
```bash
php artisan serve
```

**Terminal 2 (Frontend - Vite/Vue):**
```bash
npm run dev
```

Buka browser Anda dan akses: **`http://localhost:8000`**

### Cara Login
1. Buka halaman login web Anda.
2. Masukkan email Super Admin (secara default: `hizkiakevin8@gmail.com`).
3. Sistem akan mengirimkan **Magic Link** ke kotak masuk (Inbox/Spam) Gmail Anda.
4. Klik tombol di email tersebut, dan Anda akan otomatis masuk ke sistem tanpa *password*!

---

## Menjalankan Automated Testing (Opsional)
Aplikasi ini sudah dilengkapi dengan 23 skenario pengujian otomatis menggunakan **Pest**. Untuk menjalankannya:
```bash
php artisan test
```

## Teknologi yang Digunakan
- **Backend:** Laravel 13, PHP 8.3+
- **Frontend:** Vue.js 3, Inertia.js, Tailwind CSS
- **Database:** MySQL
- **Testing:** Pest
- **AI Integration:** Google Gemini 1.5 Flash API

---
*Dikembangkan untuk PT Kereta Api Indonesia (Persero) DAOP 5 Purwokerto.*
