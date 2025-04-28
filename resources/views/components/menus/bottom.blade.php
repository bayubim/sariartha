<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm border-bottom">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand fw-bold text-dark" href="/" wire:navigate>
            <i class="bi bi-shop-window me-1"></i> Sariartha
        </a>

        {{-- Toggle button untuk mobile --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu dan search --}}
        <div class="collapse navbar-collapse" id="navbarContent">
            {{-- Menu navigasi --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="/" wire:navigate>
                        <i class="bi bi-house-door-fill me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="/products" wire:navigate>
                        <i class="bi bi-grid-fill me-1"></i> Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="/account/my-orders" wire:navigate>
                        <i class="bi bi-receipt me-1"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="/cart" wire:navigate>
                        <i class="bi bi-cart-fill me-1"></i> Cart
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark fw-semibold" href="/login" wire:navigate>
                        <i class="bi bi-person-circle me-1"></i> Account
                    </a>
                </li>
            </ul>

            {{-- Search bar --}}
            <form class="d-flex me-3" action="/products" method="GET">
                <input
                    class="form-control form-control-sm px-3 py-2 rounded-pill border border-dark shadow-sm shadow-lg"
                    type="search" name="search" placeholder="Cari jajan..." aria-label="Search">
            </form>

            {{-- Avatar (Hanya tampil di layar besar) --}}
            <a href="/login" class="d-none d-lg-block" wire:navigate>
                @php
                    $image = auth()->guard('customer')->check() && auth()->guard('customer')->user()->image
                        ? asset('/storage/avatars/' . auth()->guard('customer')->user()->image)
                        : 'https://cdn.jsdelivr.net/gh/SantriKoding-com/assets-food-store/images/user.png';
                @endphp
                <img src="{{ $image }}" class="rounded-circle shadow-sm" height="35" width="35"
                    style="object-fit: cover;" />
            </a>
        </div>
    </div>
</nav>