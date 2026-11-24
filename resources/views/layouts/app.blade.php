<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Master Ekspedisi') - Ekspedisi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="header">
        <h1>@yield('heading', 'MASTER ADMIN - EKSPEDISI')</h1>
        <div class="line"></div>
        <div class="d-flex justify-content-center align-items-center gap-3">
            @yield('header-action')
            @auth
                <span>{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Logout</button>
                </form>
            @endauth
        </div>
    </div>

    @auth
        <nav class="navbar navbar-expand-sm bg-white rounded shadow-sm mb-4" aria-label="Navigasi master admin">
            <div class="container-fluid">
                <div class="navbar-nav">
                    <a
                        class="nav-link {{ request()->is('layanan*') ? 'active' : '' }}"
                        href="{{ url('/layanan') }}"
                        @if (request()->is('layanan*')) aria-current="page" @endif
                    >Kurir</a>
                    <a
                        class="nav-link {{ request()->is('voucher*') ? 'active' : '' }}"
                        href="{{ url('/voucher') }}"
                        @if (request()->is('voucher*')) aria-current="page" @endif
                    >Voucher</a>
                    <a
                        class="nav-link {{ request()->is('alamat*') ? 'active' : '' }}"
                        href="{{ url('/alamat') }}"
                        @if (request()->is('alamat*')) aria-current="page" @endif
                    >Alamat</a>
                </div>
            </div>
        </nav>
    @endauth

    <div class="main-container-page">
        @if (session('success'))
            <div class="notice" role="status">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
