<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class VoucherController extends Controller
{
    /**
     * Halaman Utama: Master Voucher & Promo (E-commers.php)
     */
    public function index()
    {
        $vouchers = Schema::hasTable('vouchers')
            ? Voucher::orderBy('id', 'asc')->get()
            : collect();

        return view('e-commers', compact('vouchers'));
    }

    /**
     * Halaman Kelola Voucher & Promo (input-promo.php)
     */
    public function manage(Request $request)
    {
        $vouchers = Schema::hasTable('vouchers')
            ? Voucher::orderBy('id', 'asc')->get()
            : collect();

        $editVoucher = null;

        if ($request->has('edit') && Schema::hasTable('vouchers')) {
            $editVoucher = Voucher::find($request->query('edit'));
        }

        return view('input-promo', compact('vouchers', 'editVoucher'));
    }

    /**
     * Simpan Voucher Baru
     */
    public function store(Request $request)
    {
        $jenis = $request->input('jenis');
        if (str_contains((string) $jenis, 'Persentase')) {
            $jenis = 'Persentase';
        } elseif (str_contains((string) $jenis, 'Nominal')) {
            $jenis = 'Nominal';
        }
        $request->merge(['jenis' => $jenis]);

        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:vouchers,kode',
            'nama' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:Persentase,Nominal',
            'nilai' => 'required|integer|min:0',
            'minimal' => 'required|integer|min:0',
            'maksimal' => 'nullable|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|in:Aktif,Nonaktif',
        ]);

        $validated['maksimal'] = $validated['maksimal'] ?? 0;
        $validated['status'] = $validated['status'] ?? 'Aktif';

        Voucher::create($validated);

        return redirect()->back()->with('success', 'Voucher berhasil ditambahkan!');
    }

    /**
     * Update Data Voucher
     */
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $jenis = $request->input('jenis');
        if (str_contains((string) $jenis, 'Persentase')) {
            $jenis = 'Persentase';
        } elseif (str_contains((string) $jenis, 'Nominal')) {
            $jenis = 'Nominal';
        }
        $request->merge(['jenis' => $jenis]);

        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:vouchers,kode,' . $voucher->id,
            'nama' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:Persentase,Nominal',
            'nilai' => 'required|integer|min:0',
            'minimal' => 'required|integer|min:0',
            'maksimal' => 'nullable|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|in:Aktif,Nonaktif',
        ]);

        $validated['maksimal'] = $validated['maksimal'] ?? 0;
        $validated['status'] = $validated['status'] ?? 'Aktif';

        $voucher->update($validated);

        return redirect()->route('voucher.manage')->with('success', 'Voucher berhasil diperbarui!');
    }

    /**
     * Hapus Voucher
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->back()->with('success', 'Voucher berhasil dihapus!');
    }
}
