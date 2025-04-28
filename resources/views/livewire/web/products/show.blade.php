@section('title')
{{ $product->title }} - Sariartha Kue
@stop

@section('keywords')
Sariartha Kue
@stop

@section('description')
{{ $product->description }}
@stop

@section('image')
{{ asset('/storage/' . $product->image) }}
@stop

<div class="container-fluid px-0 mt-4" style="padding-top: 100px; overflow: hidden;">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="row g-4">
                <!-- Gambar Produk -->
                <div class="col-md-5">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded shadow-sm w-100"
                            style="height: 300px; object-fit: cover; object-position: center;"
                            alt="{{ $product->title }}">
                    </div>
                </div>

                <!-- Informasi Produk -->
                <div class="col-md-7">
                    <h3 class="fw-semibold mb-3">{{ $product->title }}</h3>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fs-4 text-success fw-bold">Rp {{ number_format($product->price) }}</span>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-star-fill text-warning me-1"></i>
                            <span class="fw-medium">{{ number_format($product->ratings_avg_rating, 1) }}
                                ({{ $product->ratings_count }} ulasan)</span>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-semibold">Deskripsi</h6>
                    <p class="text-muted">{!! $product->description !!}</p>

                    <!-- Tombol Add to Cart -->
                    <div class="mt-4 button-success">
                        <livewire:web.cart.btn-add-to-cart-full :product_id="$product->id" />
                    </div>
                </div>
            </div>

            <!-- Review Section -->
            <div class="mt-5">
                <h5 class="fw-semibold mb-3">
                    <i class="bi bi-chat-left-text me-2"></i>Ulasan Pelanggan
                </h5>
                <div class="row">
                    @forelse($product->ratings()->latest()->get() as $rating)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm border-0 rounded h-100">
                                <div class="card-body">
                                    <!-- Stars -->
                                    <div class="mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="bi bi-star-fill {{ $rating->rating >= $i ? 'text-warning' : 'text-secondary' }}"></i>
                                        @endfor
                                    </div>

                                    <!-- Review text -->
                                    <p class="fst-italic text-muted">"{{ $rating->review }}"</p>

                                    <!-- Customer info -->
                                    <div class="d-flex align-items-center mt-3">
                                        <img src="{{ asset('/storage/avatars/' . $rating->customer->image) }}"
                                            alt="{{ $rating->customer->name }}" class="rounded-circle border me-2"
                                            width="40">
                                        <span class="fw-semibold">{{ $rating->customer->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
                    @endforelse
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