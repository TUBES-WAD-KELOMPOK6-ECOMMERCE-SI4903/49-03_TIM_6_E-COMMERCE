<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('layanan', function (Blueprint $table): void {
            $table->unsignedBigInteger('tarif')->change();
        });
    }

    public function down(): void
    {
        if (DB::table('layanan')->where('tarif', '>', 4294967295)->exists()) {
            throw new RuntimeException('Cannot shrink layanan.tarif while values exceed the unsigned integer range.');
        }

        Schema::table('layanan', function (Blueprint $table): void {
            $table->unsignedInteger('tarif')->change();
        });
    }
};
