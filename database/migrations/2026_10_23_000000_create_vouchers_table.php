<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('vouchers')) {
            Schema::create('vouchers', function (Blueprint $table) {
                $table->id();
                $table->string('kode', 50)->unique();
                $table->string('nama', 150);
                $table->text('deskripsi')->nullable();
                $table->enum('jenis', ['Persentase', 'Nominal']);
                $table->integer('nilai');
                $table->integer('minimal');
                $table->integer('maksimal')->default(0);
                $table->date('tanggal_mulai');
                $table->date('tanggal_berakhir');
                $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            });
        } else {
            Schema::table('vouchers', function (Blueprint $table) {
                if (!Schema::hasColumn('vouchers', 'updated_at')) {
                    $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
