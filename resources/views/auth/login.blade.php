@extends('layouts.app')

@section('title', 'Login Master Admin')
@section('heading', 'LOGIN MASTER ADMIN')

@section('content')
    <div class="card-table mx-auto" style="max-width: 520px;">
        <h2>Masuk ke Dashboard</h2>
        <form action="{{ route('login.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input
                    class="form-control @error('username') is-invalid @enderror"
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    autocomplete="username"
                    required
                    autofocus
                >
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    class="form-control @error('password') is-invalid @enderror"
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="current-password"
                    required
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
@endsection
