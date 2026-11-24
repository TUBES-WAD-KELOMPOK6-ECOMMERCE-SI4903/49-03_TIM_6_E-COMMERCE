<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vouchers = [
            [
                'kode' => 'HEMAT20',
                'nama' => 'Promo Hemat September',
                'deskripsi' => 'Diskon khusus pelanggan',
                'jenis' => 'Persentase',
                'nilai' => 20,
                'minimal' => 100000,
                'maksimal' => 50000,
                'tanggal_mulai' => '2026-09-23',
                'tanggal_berakhir' => '2026-09-30',
                'status' => 'Aktif',
            ],
            [
                'kode' => 'DISKON50K',
                'nama' => 'Belanja Hemat',
                'deskripsi' => 'Potongan belanja hemat',
                'jenis' => 'Nominal',
                'nilai' => 50000,
                'minimal' => 200000,
                'maksimal' => 50000,
                'tanggal_mulai' => '2026-09-23',
                'tanggal_berakhir' => '2026-10-15',
                'status' => 'Aktif',
            ],
            [
                'kode' => 'HEMAT10',
                'nama' => 'Promo Pelanggan',
                'deskripsi' => 'Promo khusus member setia',
                'jenis' => 'Persentase',
                'nilai' => 10,
                'minimal' => 75000,
                'maksimal' => 25000,
                'tanggal_mulai' => '2026-10-01',
                'tanggal_berakhir' => '2026-10-31',
                'status' => 'Aktif',
            ],
        ];

        foreach ($vouchers as $voucher) {
            Voucher::updateOrCreate(
                ['kode' => $voucher['kode']],
                $voucher
            );
        }
    }
}
