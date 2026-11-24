<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Voucher &amp; Promo</title>
    <link rel="stylesheet" href="{{ asset('css/voucher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-navigation.css') }}">
</head>
<body>
    <header class="header">
        <h1>MASTER ADMIN - VOUCHER &amp; PROMO</h1>
        <div class="line" aria-hidden="true"></div>
        <a href="{{ route('voucher.manage') }}" class="btn-action">Kelola Voucher</a>
    </header>

    @include('layouts.navigation')

    <main class="main-container-page">
        <p class="page-description">Kelola penawaran voucher dan promo untuk pelanggan toko.</p>

        @if (session('success'))
            <div class="notice" role="status">{{ session('success') }}</div>
        @endif

        <section class="card-table full-width" aria-labelledby="voucher-list-title">
            <div class="card-header-flex">
                <div>
                    <h2 id="voucher-list-title">Daftar Voucher &amp; Promo</h2>
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
                            <th>Jenis Diskon</th>
                            <th>Nilai</th>
                            <th>Min. Belanja</th>
                            <th>Periode</th>
                            <th>Status</th>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">Belum ada voucher yang tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
