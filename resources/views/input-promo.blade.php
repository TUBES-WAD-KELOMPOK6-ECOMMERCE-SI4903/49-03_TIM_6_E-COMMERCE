<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Voucher &amp; Promo</title>
    <link rel="stylesheet" href="{{ asset('css/voucher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-navigation.css') }}">
</head>
<body>
    <header class="header">
        <h1>KELOLA VOUCHER &amp; PROMO</h1>
        <div class="line" aria-hidden="true"></div>
        <a href="{{ route('voucher.index') }}" class="btn-action">Kembali ke Daftar</a>
    </header>

    @include('layouts.navigation')

    <main class="main-container-page">
        <p class="page-description">Tambahkan dan kelola kode voucher promo untuk pelanggan toko.</p>

        @if (session('success'))
            <div class="notice" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="notice notice-error" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $isEditing = isset($editVoucher) && $editVoucher;
            $selectedJenis = old('jenis', $editVoucher->jenis ?? '');
            $selectedStatus = old('status', $editVoucher->status ?? 'Aktif');
        @endphp

        <section class="card-form form-center" aria-labelledby="voucher-form-title">
            <div class="card-section-heading">
                <h2 id="voucher-form-title">{{ $isEditing ? 'Edit Voucher' : 'Tambah Voucher Baru' }}</h2>
                <p>Lengkapi detail promo yang ingin ditampilkan kepada pelanggan.</p>
            </div>

            <form action="{{ $isEditing ? route('voucher.update', $editVoucher->id) : route('voucher.store') }}" method="POST">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="kode">Kode Voucher</label>
                    <input class="form-control" type="text" id="kode" name="kode" value="{{ old('kode', $editVoucher->kode ?? '') }}" placeholder="Contoh: HEMAT20" maxlength="50" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Promo</label>
                    <input class="form-control" type="text" id="nama" name="nama" value="{{ old('nama', $editVoucher->nama ?? '') }}" placeholder="Contoh: Promo Hemat September" maxlength="150" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Promo <span class="optional-label">Opsional</span></label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan promo secara singkat">{{ old('deskripsi', $editVoucher->deskripsi ?? '') }}</textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="jenis">Jenis Diskon</label>
                        <select class="form-control" id="jenis" name="jenis" required>
                            <option value="">Pilih jenis diskon</option>
                            <option value="Persentase" @selected($selectedJenis === 'Persentase')>Persentase (%)</option>
                            <option value="Nominal" @selected($selectedJenis === 'Nominal')>Nominal (Rp)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nilai">Nilai Diskon</label>
                        <input class="form-control" type="number" id="nilai" name="nilai" value="{{ old('nilai', $editVoucher->nilai ?? '') }}" placeholder="Contoh: 20" min="0" required>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="minimal">Minimal Belanja (Rp)</label>
                        <input class="form-control" type="number" id="minimal" name="minimal" value="{{ old('minimal', $editVoucher->minimal ?? '') }}" placeholder="Contoh: 100000" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="maksimal">Maksimal Potongan (Rp) <span class="optional-label">Opsional</span></label>
                        <input class="form-control" type="number" id="maksimal" name="maksimal" value="{{ old('maksimal', $editVoucher->maksimal ?? '') }}" placeholder="Contoh: 50000" min="0">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input class="form-control" type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $editVoucher->tanggal_mulai ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_berakhir">Tanggal Berakhir</label>
                        <input class="form-control" type="date" id="tanggal_berakhir" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', $editVoucher->tanggal_berakhir ?? '') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status Voucher</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Aktif" @selected($selectedStatus === 'Aktif')>Aktif</option>
                        <option value="Nonaktif" @selected($selectedStatus === 'Nonaktif')>Nonaktif</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">{{ $isEditing ? 'Simpan Perubahan' : 'Simpan Voucher' }}</button>
                    @if ($isEditing)
                        <a href="{{ route('voucher.manage') }}" class="btn-cancel">Batal</a>
                    @endif
                </div>
            </form>
        </section>

        <section class="card-table full-width voucher-table-card" aria-labelledby="voucher-list-title">
            <div class="card-header-flex">
                <div>
                    <h2 id="voucher-list-title">Voucher Terdaftar</h2>
                    <p class="card-caption">{{ $vouchers->count() }} voucher tersedia</p>
                </div>
            </div>

            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Voucher</th>
                            <th>Nama Promo</th>
                            <th>Jenis</th>
                            <th>Nilai</th>
                            <th>Min. Belanja</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vouchers as $index => $v)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $v->kode }}</strong></td>
                                <td>
                                    <span class="table-primary-text">{{ $v->nama }}</span>
                                    @if ($v->deskripsi)
                                        <span class="table-secondary-text">{{ $v->deskripsi }}</span>
                                    @endif
                                </td>
                                <td>{{ $v->jenis }}</td>
                                <td>
                                    @if ($v->jenis === 'Persentase')
                                        {{ $v->nilai }}%
                                    @else
                                        Rp {{ number_format($v->nilai, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>Rp {{ number_format($v->minimal, 0, ',', '.') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($v->tanggal_mulai)->format('d M Y') }}
                                    <span class="table-secondary-text">s.d. {{ \Carbon\Carbon::parse($v->tanggal_berakhir)->format('d M Y') }}</span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $v->status === 'Aktif' ? 'status-active' : 'status-inactive' }}">
                                        {{ $v->status }}
                                    </span>
                                </td>
                                <td class="action-cell">
                                    <a href="{{ route('voucher.manage', ['edit' => $v->id]) }}" class="btn-sm btn-edit">Edit</a>
                                    <form action="{{ route('voucher.destroy', $v->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus voucher ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="empty-state">Belum ada voucher yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
