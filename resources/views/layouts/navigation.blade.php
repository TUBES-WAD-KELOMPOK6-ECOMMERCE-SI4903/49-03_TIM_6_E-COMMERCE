@auth
    <nav class="admin-navigation" aria-label="Navigasi master admin">
        <a
            class="{{ request()->is('layanan*') ? 'active' : '' }}"
            href="{{ url('/layanan') }}"
            @if (request()->is('layanan*')) aria-current="page" @endif
        >Kurir</a>
        <a
            class="{{ request()->routeIs('voucher.*') ? 'active' : '' }}"
            href="{{ route('voucher.index') }}"
            @if (request()->routeIs('voucher.*')) aria-current="page" @endif
        >Voucher</a>
        <a
            class="{{ request()->is('alamat*') ? 'active' : '' }}"
            href="{{ url('/alamat') }}"
            @if (request()->is('alamat*')) aria-current="page" @endif
        >Alamat</a>
        <a
            class="{{ request()->is('produk*') ? 'active' : '' }}"
            href="{{ route('produk.index') }}"
            @if (request()->is('produk*')) aria-current="page" @endif
        >Katalog Produk</a>
    </nav>
@endauth
