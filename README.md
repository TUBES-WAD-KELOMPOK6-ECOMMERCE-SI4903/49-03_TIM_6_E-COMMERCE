# E-Commerce Laravel

Aplikasi e-commerce berbasis **Laravel 12** untuk mengelola katalog produk, voucher dan promo, profil pelanggan beserta alamat pengiriman, serta layanan ekspedisi. Proyek ini menggunakan **PHP 8.2+**, SQLite secara default, dan mendukung MySQL.

## Fitur

- Autentikasi pengguna berbasis session dengan login dan logout.
- Peran pengguna `master_admin`, `admin`, dan `user`.
- Manajemen produk untuk admin: tambah, lihat, ubah, dan hapus produk.
- Manajemen voucher dan promo: persentase atau nominal, periode berlaku, batas pembelian, dan status.
- Manajemen profil pelanggan beserta alamat pengiriman.
- Manajemen layanan ekspedisi untuk Master Admin.
- REST API untuk layanan ekspedisi.
- Koleksi Postman untuk membantu pengujian API.

## Teknologi

- Laravel 12
- PHP 8.2+
- SQLite atau MySQL
- Blade Template
- Tailwind CSS dan Vite
- PHPUnit

## Persiapan dan Instalasi

### Persyaratan

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm
- Ekstensi PHP yang dibutuhkan Laravel
- SQLite atau MySQL

### Instalasi Cepat

1. Masuk ke folder proyek:

   ```powershell
   cd "C:\Users\USER\Documents\SMT 3\PAW\E-COMMERCE"
   ```

2. Pasang dependensi PHP:

   ```powershell
   composer install
   ```

3. Buat file konfigurasi lingkungan:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Buat application key:

   ```powershell
   php artisan key:generate
   ```

5. Buat atau pastikan file database SQLite tersedia:

   ```powershell
   New-Item -ItemType File -Force database/database.sqlite
   ```

6. Jalankan migrasi dan seeder:

   ```powershell
   php artisan migrate --seed
   ```

7. Pasang dan build aset frontend:

   ```powershell
   npm install
   npm run build
   ```

8. Jalankan aplikasi:

   ```powershell
   php artisan serve
   ```

9. Buka `http://127.0.0.1:8000`.

Untuk menjalankan server Laravel dan aset Vite secara bersamaan, gunakan:

```powershell
composer run dev
```

## Konfigurasi Database

### SQLite

Pengaturan default pada `.env.example` menggunakan SQLite:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### MySQL

Nyalakan MySQL, buat database misalnya `e-commerce`, lalu ubah konfigurasi pada `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e-commerce
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian jalankan:

```powershell
php artisan migrate --seed
```

## Akun Demo

Data seeder membuat beberapa akun demonstrasi:

| Peran | Username | Password |
| --- | --- | --- |
| Master Admin | `admin1` | `admin1` |
| Admin | `admin2` | `admin2` |
| User | `notadmin` | `notadmin` |

Kredensial di atas hanya untuk pengembangan dan demo lokal. Segera ubah sebelum menjalankan aplikasi di lingkungan produksi.

Konfigurasi Master Admin dapat diatur pada `.env`:

```dotenv
MASTER_ADMIN_NAME="Master Admin"
MASTER_ADMIN_USERNAME=admin1
MASTER_ADMIN_EMAIL=admin1@example.com
MASTER_ADMIN_PASSWORD=admin1
```

## Halaman Utama

Setelah login, pengguna diarahkan ke katalog produk.

| Halaman | Path | Keterangan |
| --- | --- | --- |
| Login | `/login` | Autentikasi pengguna |
| Katalog Produk | `/produk` | Daftar produk |
| Kelola Voucher | `/input-promo` | Tambah, ubah, dan hapus voucher |
| Daftar Voucher | `/e-commers` | Tampilan voucher dan promo |
| Profil Pelanggan | `/profil` | Kelola profil pelanggan |
| Alamat Pengiriman | `/alamat` | Kelola alamat pelanggan |
| Form Pelanggan | `/form` | Form profil dan pilihan pelanggan |
| Layanan Ekspedisi | `/layanan` | CRUD layanan, khusus Master Admin |

## Struktur Modul

- `app/Http/Controllers/ProdukController.php` — katalog dan CRUD produk.
- `app/Http/Controllers/VoucherController.php` — pengelolaan voucher dan promo.
- `app/Http/Controllers/ProfilController.php` — data profil pelanggan.
- `app/Http/Controllers/AlamatController.php` — alamat pengiriman pelanggan.
- `app/Http/Controllers/LayananController.php` — CRUD layanan ekspedisi.
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php` — login dan logout.
- `app/Http/Middleware/EnsureMasterAdmin.php` — pembatasan akses Master Admin.
- `database/migrations/` — struktur tabel database.
- `database/seeders/` — akun demo, layanan, dan voucher awal.
- `resources/views/` — antarmuka berbasis Blade.
- `routes/web.php` — route halaman web.
- `routes/api.php` — route REST API.

## REST API Layanan Ekspedisi

Base URL:

```text
http://127.0.0.1:8000/api
```

Seluruh endpoint layanan memerlukan pengguna yang sudah login sebagai Master Admin. Permintaan mutasi juga wajib menyertakan cookie session dan CSRF token dari sesi web.

| Method | Endpoint | Fungsi |
| --- | --- | --- |
| GET | `/layanan` | Daftar layanan |
| GET | `/layanan/{id}` | Detail layanan |
| POST | `/layanan` | Tambah layanan |
| PUT/PATCH | `/layanan/{id}` | Ubah layanan |
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

Nama ekspedisi otomatis disimpan dalam huruf kapital. Nilai `status` bersifat opsional saat membuat layanan dan default-nya adalah `ON`.

## Pengujian

Menjalankan seluruh pengujian:

```powershell
php artisan test
```

Menjalankan pengujian tertentu:

```powershell
php artisan test tests/Feature/LayananTest.php
php artisan test tests/Feature/AuthenticationTest.php
```

## Postman

Import `postman_collection.json` ke Postman untuk menguji REST API. Login melalui aplikasi atau endpoint `/login` terlebih dahulu, kemudian gunakan cookie session dan CSRF token untuk permintaan mutasi.
