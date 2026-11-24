<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $__env->yieldContent('title', $__env->yieldContent('judul', 'Master Ekspedisi')) }} - Ekspedisi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-navigation.css') }}">
</head>
<body>
    <div class="header">
        <h1>{{ $__env->yieldContent('heading', $__env->yieldContent('judul', 'MASTER ADMIN - EKSPEDISI')) }}</h1>
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

    @include('layouts.navigation')

    <div class="main-container-page">
        @if (session('success'))
            <div class="notice" role="status">{{ session('success') }}</div>
        @endif

        @if (session('sukses'))
            <div class="notice" role="status">{{ session('sukses') }}</div>
        @endif

        @if (session('error'))
            <div class="notice notice-error" role="alert">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="notice notice-error" role="alert">
                @foreach ($errors->all() as $pesan)
                    <div>{{ $pesan }}</div>
                @endforeach
            </div>
        @endif

        @yield('content')
        @yield('isi')
    </div>
</body>
</html>