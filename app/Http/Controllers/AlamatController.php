<?php

namespace App\Http\Controllers;

use App\Models\AlamatPengiriman;
use App\Models\ProfilPelanggan;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    private function aturan(): array
    {
        return [
            'id_pelanggan' => ['required', 'exists:profil_pelanggan,id'],
            'label'        => ['required', 'string', 'max:50'],
            'penerima'     => ['required', 'string', 'max:100'],
            'alamat'       => ['required', 'string'],
        ];
    }

    public function index(Request $request)
    {
        $filter = (int) $request->query('pelanggan', 0);

        $profil = $filter > 0 ? ProfilPelanggan::find($filter) : null;

        $query = AlamatPengiriman::with('pelanggan')->latest('id');
        if ($filter > 0) {
            $query->where('id_pelanggan', $filter);
        }

        $daftar     = $query->get();
        $profilList = ProfilPelanggan::orderBy('nama_lengkap')->get();

        return view('alamat.index', compact('daftar', 'profil', 'profilList', 'filter'));
    }

    public function store(Request $request)
    {
        AlamatPengiriman::create($request->validate($this->aturan()));

        return redirect()->route('alamat.index')->with('sukses', 'Alamat berhasil ditambahkan!');
    }

    public function edit(AlamatPengiriman $alamat)
    {
        $profilList = ProfilPelanggan::orderBy('nama_lengkap')->get();

        return view('alamat.edit', compact('alamat', 'profilList'));
    }

    public function update(Request $request, AlamatPengiriman $alamat)
    {
        $alamat->update($request->validate($this->aturan()));

        return redirect()->route('alamat.index')->with('sukses', 'Data alamat berhasil diperbarui!');
    }

    public function destroy(AlamatPengiriman $alamat)
    {
        $alamat->delete();

        return redirect()->route('alamat.index')->with('sukses', 'Data alamat berhasil dihapus!');
    }
}
