@extends('layouts.app')
@section('judul', 'Edit Profil')

@section('isi')
<div class="form-center">
    <section class="card-form">
        <h2>Edit Profil Pelanggan</h2>
        <form method="POST" action="{{ route('profil.update', $profil->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input id="nama_lengkap" type="text" name="nama_lengkap" class="form-control"
                       value="{{ old('nama_lengkap', $profil->nama_lengkap) }}" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email', $profil->email) }}" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="no_telepon">No. Telepon</label>
                <input id="no_telepon" type="tel" name="no_telepon" class="form-control"
                       value="{{ old('no_telepon', $profil->no_telepon) }}" maxlength="20" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                <a href="{{ route('profil.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </section>
</div>
@endsection
