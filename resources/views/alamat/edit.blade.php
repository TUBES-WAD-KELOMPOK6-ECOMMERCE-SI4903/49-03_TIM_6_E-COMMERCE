@extends('layouts.app')
@section('judul', 'Edit Alamat')

@section('isi')
<div class="form-center">
    <section class="card-form">
        <h2>Edit Data Alamat</h2>
        <form method="POST" action="{{ route('alamat.update', $alamat->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="id_pelanggan">Pemilik Alamat</label>
                <select id="id_pelanggan" name="id_pelanggan" class="form-control" required>
                    @foreach ($profilList as $p)
                        <option value="{{ $p->id }}" @selected(old('id_pelanggan', $alamat->id_pelanggan) == $p->id)>
                            {{ $p->nama_lengkap }} ({{ $p->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="label">Label Alamat</label>
                <input id="label" type="text" name="label" class="form-control"
                       value="{{ old('label', $alamat->label) }}" maxlength="50" required>
            </div>
            <div class="form-group">
                <label for="penerima">Nama Penerima</label>
                <input id="penerima" type="text" name="penerima" class="form-control"
                       value="{{ old('penerima', $alamat->penerima) }}" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" class="form-control" rows="3" required>{{ old('alamat', $alamat->alamat) }}</textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                <a href="{{ route('alamat.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </section>
</div>
@endsection
