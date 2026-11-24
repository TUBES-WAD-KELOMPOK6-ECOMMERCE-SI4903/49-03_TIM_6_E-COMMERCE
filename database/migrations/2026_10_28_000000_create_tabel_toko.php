<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tabel dibuat HANYA jika belum ada, jadi aman untuk db_toko yang sudah berisi data.
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('profil_pelanggan')) {
            Schema::create('profil_pelanggan', function (Blueprint $table) {
                $table->integer('id', true); // INT auto increment (signed), sama seperti di phpMyAdmin
                $table->string('nama_lengkap', 100);
                $table->string('email', 100)->unique();
                $table->string('no_telepon', 20);
            });
        }

        if (!Schema::hasTable('alamat_pengiriman')) {
            Schema::create('alamat_pengiriman', function (Blueprint $table) {
                $table->integer('id', true);
                $table->integer('id_pelanggan'); // harus sama tipe dengan profil_pelanggan.id
                $table->string('label', 50);
                $table->string('penerima', 100);
                $table->text('alamat');

                $table->foreign('id_pelanggan')
                    ->references('id')->on('profil_pelanggan')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('alamat_pengiriman');
        Schema::dropIfExists('profil_pelanggan');
    }
};
