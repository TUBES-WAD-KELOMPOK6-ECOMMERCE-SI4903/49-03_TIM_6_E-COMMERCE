@extends('layouts.app')
@section('judul', 'Daftar Profil')

@section('isi')
<section class="card-table full-width">
    <div class="card-header-flex">
        <div>
            <h2>Daftar Profil Pelanggan</h2>
            <p class="section-description">Kelola informasi pelanggan yang terdaftar di toko.</p>
        </div>
        <a href="{{ route('form') }}" class="btn-action">+ Tambah Profil</a>
    </div>

    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftar as $p)
                    <tr>
                        <td><strong>{{ $p->nama_lengkap }}</strong></td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->no_telepon }}</td>
                        <td>
                            <a href="{{ route('alamat.index', ['pelanggan' => $p->id]) }}">
                                {{ $p->alamat_count }} alamat
                            </a>
                        </td>
                        <td class="action-cell">
                            <a href="{{ route('profil.edit', $p->id) }}" class="btn btn-sm btn-edit">Edit</a>
                            <form action="{{ route('profil.destroy', $p->id) }}" method="POST" class="inline-form"
                                  onsubmit="return confirm('Hapus profil ini? {{ $p->alamat_count }} alamat milik profil ini juga akan ikut terhapus permanen.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">Belum ada profil. Silakan tambah data melalui Form Input.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
