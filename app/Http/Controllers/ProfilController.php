<?php

namespace App\Http\Controllers;

use App\Models\ProfilPelanggan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function index()
    {
        $daftar = ProfilPelanggan::withCount('alamat')->latest('id')->get();

        return view('profil.index', compact('daftar'));
    }

    public function create()
    {
        $profilList = ProfilPelanggan::orderBy('nama_lengkap')->get();

        return view('form', compact('profilList'));
    }

    private function aturan(?int $abaikanId = null): array
    {
        $unik = Rule::unique('profil_pelanggan', 'email');
        if ($abaikanId) {
            $unik->ignore($abaikanId);
        }

        return [
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:100', $unik],
            'no_telepon'   => ['required', 'string', 'max:20'],
        ];
    }

    public function store(Request $request)
    {
        ProfilPelanggan::create($request->validate($this->aturan()));

        return redirect()->route('profil.index')->with('sukses', 'Profil berhasil disimpan!');
    }

    public function edit(ProfilPelanggan $profil)
    {
        return view('profil.edit', compact('profil'));
    }

    public function update(Request $request, ProfilPelanggan $profil)
    {
        $profil->update($request->validate($this->aturan($profil->id)));

        return redirect()->route('profil.index')->with('sukses', 'Profil berhasil diperbarui!');
    }

    public function destroy(ProfilPelanggan $profil)
    {
        $jumlah = $profil->alamat()->count();

        $profil->delete();

        return redirect()->route('profil.index')
            ->with('sukses', "Profil berhasil dihapus beserta $jumlah alamat miliknya.");
    }
}
