@extends('layouts.app')
@section('judul', 'Daftar Alamat')

@section('isi')
@if ($profil)
    <section class="profile-summary" aria-label="Informasi pelanggan">
        <div class="summary-item">
            <span>Nama Lengkap</span>
            <strong>{{ $profil->nama_lengkap }}</strong>
        </div>
        <div class="summary-item">
            <span>Email</span>
            <strong>{{ $profil->email }}</strong>
        </div>
        <div class="summary-item">
            <span>No. Telepon</span>
            <strong>{{ $profil->no_telepon }}</strong>
        </div>
    </section>
@endif

<section class="card-table full-width">
    <div class="card-header-flex">
        <div>
            <h2>Direktori Alamat Pengiriman</h2>
            <p class="section-description">Kelola alamat yang tersimpan untuk pelanggan.</p>
        </div>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <a href="{{ route('form') }}" class="btn-action">+ Tambah Alamat</a>
            <form method="GET" action="{{ route('alamat.index') }}" class="filter-form">
                <label for="pelanggan">Tampilkan alamat milik</label>
                <select id="pelanggan" name="pelanggan" class="form-control filter-select" onchange="this.form.submit()">
                    <option value="0">Semua profil</option>
                    @foreach ($profilList as $p)
                        <option value="{{ $p->id }}" @selected($filter === $p->id)>
                            {{ $p->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Penerima</th>
                    <th>Alamat</th>
                    <th>Pemilik</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftar as $row)
                    <tr>
                        <td><strong>{{ $row->label }}</strong></td>
                        <td>{{ $row->penerima }}</td>
                        <td>{{ $row->alamat }}</td>
                        <td>
                            {{ $row->pelanggan->nama_lengkap }}<br>
                            <small>{{ $row->pelanggan->email }}</small>
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('alamat.edit', $row->id) }}" class="btn btn-sm btn-edit">Edit</a>
                            <form action="{{ route('alamat.destroy', $row->id) }}" method="POST" class="inline-form"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">Belum ada data alamat pengiriman. Silakan tambah data melalui Form Input.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
