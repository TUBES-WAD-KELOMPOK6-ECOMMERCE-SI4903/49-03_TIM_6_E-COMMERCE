@extends('layouts.app')
@section('judul', 'Form Input')

@section('isi')
<div class="page-grid">
    <section class="card-form">
        <h2>Profil Pelanggan</h2>
        <p class="card-description">Tambahkan informasi pelanggan ke dalam daftar toko.</p>

        <form method="POST" action="{{ route('profil.store') }}">
            @csrf
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control"
                       placeholder="Nama Anda" value="{{ old('nama_lengkap') }}" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control"
                       placeholder="email@contoh.com" value="{{ old('email') }}" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="no_telepon">No. Telepon</label>
                <input id="no_telepon" type="tel" name="no_telepon" class="form-control"
                       placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}" maxlength="20" required>
            </div>
            <button type="submit" class="btn-submit">Simpan Profil</button>
        </form>
    </section>

    <section class="card-form">
        <h2>Tambah Alamat</h2>
        <p class="card-description">Simpan alamat pengiriman untuk pelanggan yang terdaftar.</p>

        @if ($profilList->isEmpty())
            <p class="notice notice-info">Belum ada profil. Simpan profil terlebih dahulu sebelum menambah alamat.</p>
        @endif

        <form method="POST" action="{{ route('alamat.store') }}">
            @csrf
            <div class="form-group">
                <label for="id_pelanggan">Pemilik Alamat</label>
                <select id="id_pelanggan" name="id_pelanggan" class="form-control" required @disabled($profilList->isEmpty())>
                    <option value="">-- Pilih profil --</option>
                    @foreach ($profilList as $p)
                        <option value="{{ $p->id }}" @selected(old('id_pelanggan') == $p->id)>
                            {{ $p->nama_lengkap }} ({{ $p->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="label">Label Alamat</label>
                <input id="label" type="text" name="label" class="form-control"
                       placeholder="Rumah / Kantor / Kost" value="{{ old('label') }}" maxlength="50" required>
            </div>
            <div class="form-group">
                <label for="penerima">Nama Penerima</label>
                <input id="penerima" type="text" name="penerima" class="form-control"
                       placeholder="Nama penerima paket" value="{{ old('penerima') }}" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" class="form-control" rows="2"
                          placeholder="Jalan, Kota, Kode Pos" required>{{ old('alamat') }}</textarea>
            </div>
            <button type="submit" class="btn-submit" @disabled($profilList->isEmpty())>Tambah Alamat</button>
        </form>
    </section>
</div>
@endsection
