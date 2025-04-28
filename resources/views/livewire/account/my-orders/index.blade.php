<div class="container-fluid px-0">
    <div class="row justify-content-center mt-0" style="margin-top: 50px !important; padding:0 5vw; ">
        <div class="container-fluid px-3 px-md-5">

            <x-menus.customer />

            <div class="card border-0 shadow-sm rounded">
                <div class="card-body p-4">
                    <h6 class="mb-3 d-flex align-items-center">
                        <i class="bi bi-bag me-2"></i> My Orders
                    </h6>
                    <hr />

                    @forelse ($transactions as $transaction)
                                        <div class="card rounded border mb-3 shadow-sm">
                                            <a href="{{ route('account.my-orders.show', $transaction->snap_token) }}" wire:navigate
                                                class="text-decoration-none text-dark">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-basket3 me-2 text-primary"></i>
                                                            <span class="fw-bold">Order ID #{{ $transaction->invoice }}</span>
                                                        </div>
                                                        <div>
                                                            @php
                                                                $statusClass = [
                                                                    'pending' => 'warning',
                                                                    'success' => 'success',
                                                                    'expired' => 'secondary',
                                                                    'failed' => 'danger',
                                                                    'process' => 'info',
                                                                    'delivery' => 'success',
                                                                ][$transaction->status] ?? 'dark';
                                                            @endphp
                                                            <span
                                                                class="badge bg-{{ $statusClass }} rounded-pill px-3 py-2 text-uppercase small">
                                                                {{ $transaction->status }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <hr class="my-2">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-semibold">Grand Total:</span>
                                                        <span class="fw-bold text-success">Rp.
                                                            {{ number_format($transaction->total) }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                    @empty
                        <div class="alert alert-light text-center shadow-sm mt-4">
                            <i class="bi bi-info-circle me-2"></i> You don't have any orders.
                        </div>
                    @endforelse

                    {{-- Navigasi Pagination --}}
                    <div class="mt-4">
                        {{ $transactions->links('vendor.pagination.simple-default') }}
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white pt-5 pb-4 shadow-lg mt-5 w-100" style="padding:0 5vw;">
        <div class="container-fluid px-4 px-md-5">
            <div class="row">
                {{-- Tentang Kami --}}
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold">Tentang Kami</h6>
                    <p class="small">
                        Sariartha Kue menyediakan jajanan tradisional Indonesia dengan cita rasa khas dan berkualitas.
                        Dukung UMKM lokal!
                    </p>
                </div>

                {{-- Navigasi dan Kontak --}}
                <div class="col-md-7 offset-md-1 mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h6 class="fw-bold">Navigasi</h6>
                            <ul class="list-unstyled small">
                                <li><a href="/" class="text-decoration-none text-white-50" wire:navigate>Home</a></li>
                                <li><a href="/products" class="text-decoration-none text-white-50"
                                        wire:navigate>Produk</a>
                                </li>
                                <li><a href="/cart" class="text-decoration-none text-white-50"
                                        wire:navigate>Keranjang</a>
                                </li>
                                <li><a href="/account/my-orders" class="text-decoration-none text-white-50"
                                        wire:navigate>Pesanan Saya</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Kontak Kami</h6>
                            <ul class="list-unstyled small">
                                <li><i class="bi bi-geo-alt-fill me-2"></i>Jl. Kue Tradisional No. 88</li>
                                <li><i class="bi bi-envelope-fill me-2"></i>info@sariartha.com</li>
                                <li><i class="bi bi-phone-fill me-2"></i>+62 812 3456 7890</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-light">

            <div class="text-center small text-white-50">
                &copy; {{ date('Y') }} Sariartha Kue. All rights reserved.
            </div>
        </div>
    </footer>
</div>