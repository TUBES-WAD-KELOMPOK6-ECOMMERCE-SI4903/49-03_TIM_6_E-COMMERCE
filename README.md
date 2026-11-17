# Aplikasi Layanan Ekspedisi

Aplikasi CRUD sederhana menggunakan Laravel 12, PHP 8.2+, dan MySQL. Pengguna dapat melihat, mencari, menambah, mengedit, dan menghapus layanan ekspedisi. Data yang sama juga tersedia melalui REST API.

## Menjalankan aplikasi

1. Pastikan PHP 8.2+ dan Composer tersedia.
2. Dari folder proyek, pasang dependensi:

   ```sh
   composer install
   ```

3. Salin `.env.example` menjadi `.env` (di PowerShell: `Copy-Item .env.example .env`). Setup awal menggunakan SQLite di `database/database.sqlite` dan tidak memerlukan MySQL. Jika `.env` sudah ada, pastikan `DB_CONNECTION=sqlite` dan `DB_DATABASE=database/database.sqlite`.
4. Akun demo Master Admin menggunakan username `admin1` dan password `admin1`. Untuk lingkungan selain demo/lokal, segera ubah keduanya melalui `.env`:

   ```dotenv
   MASTER_ADMIN_NAME="Master Admin"
   MASTER_ADMIN_USERNAME=admin1
   MASTER_ADMIN_EMAIL=admin1@example.com
   MASTER_ADMIN_PASSWORD=admin1
   ```

5. Buat application key dan tabel:

   ```sh
   php artisan key:generate
   php artisan migrate --seed
   ```

6. Jalankan server:

   ```sh
   php artisan serve
   ```

7. Buka `http://127.0.0.1:8000/login` dan masuk menggunakan username serta password di atas.

Seeder membuat atau memperbarui akun Master Admin dari konfigurasi tersebut dan menambahkan contoh layanan JNE dan SiCepat jika tabel masih kosong. Password `admin1` sangat lemah dan hanya ditujukan untuk demo lokal; ganti sebelum aplikasi dibuka di jaringan atau digunakan di produksi.

### Menggunakan MySQL

Nyalakan MySQL melalui XAMPP atau layanan lain dan buat database bernama `e-commerce`. Pada `.env`, ubah `DB_CONNECTION=sqlite` menjadi `DB_CONNECTION=mysql`, lalu isi `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`. Setelah itu jalankan `php artisan migrate --seed`.

### Database lama

Jika tabel `layanan` sudah dibuat menggunakan `database.sql`, migrasi akan mengenali tabel tersebut dan tidak membuat tabel duplikat. Model Laravel menggunakan kolom yang sama dengan tabel lama.

## Struktur Laravel

- `app/Models/Layanan.php`: model untuk tabel layanan.
- `app/Http/Controllers/`: logika CRUD halaman dan API.
- `app/Http/Middleware/EnsureMasterAdmin.php`: memastikan CRUD hanya dapat diakses Master Admin.
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`: login dan logout berbasis session.
- `database/migrations/`: struktur tabel.
- `database/seeders/`: akun Master Admin dan contoh data awal.
- `resources/views/`: halaman Blade.
- `routes/web.php`: route halaman web.
- `routes/api.php`: route REST API.

## REST API

Base URL API: `http://127.0.0.1:8000/api`. Seluruh endpoint layanan memerlukan session Master Admin. Login dahulu melalui `/login`; permintaan mutasi API juga harus menyertakan perlindungan CSRF dari session web.

| Method | Endpoint | Fungsi |
| --- | --- | --- |
| GET | `/layanan` | Daftar layanan |
| GET | `/layanan/{id}` | Detail layanan |
| POST | `/layanan` | Tambah layanan |
| PUT/PATCH | `/layanan/{id}` | Edit layanan |
| DELETE | `/layanan/{id}` | Hapus layanan |

Contoh body JSON:

```json
{
  "nama_ekspedisi": "Kurir Baru",
  "jenis_layanan": "Reguler",
  "zonasi": "Zona 1",
  "tarif": 10000,
  "estimasi": "2-3 Hari",
  "status": "ON"
}
```

Nama ekspedisi otomatis disimpan dalam huruf kapital. Field `status` dapat dihilangkan saat membuat layanan API; nilai awalnya `ON`. Saat menggunakan `postman_collection.json`, autentikasi dulu melalui `/login` dan sertakan cookie session serta CSRF token pada permintaan mutasi.
