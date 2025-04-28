@section('title', 'Sariartha Kue')
@section('keywords', 'Sariartha Kue')
@section('description', 'Sariartha Kue')
@section('image', asset('storage/logowhite.png'))

@section('content')
<div class="container-fluid px-0" style="margin-top: 100px; overflow: hidden;">

    {{-- Slider --}}
    <div class="row justify-content-center mt-4" style="padding:0 5vw;">
        <div class="col-12">
            <div id="carouselExample" class="carousel slide w-100">
                <div class=" carousel-inner">
                    @foreach ($sliders as $key => $slider)
                        <div class="carousel-item @if($key == 0) active @endif">
                            <img src="{{ asset('/storage/' . $slider->image) }}" class="d-block w-100 rounded">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>



    {{-- Produk Populer --}}
    <div class="row justify-content-center mt-5" style="padding:0 5vw;">
        <div class="col-12 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-bag"></i> PRODUCTS <span class="text-orange">POPULER</span>
                </h6>
                <a href="/products" wire:navigate class="text-decoration-none text-orange fw-bold">Lihat Lainnya <i
                        class="bi bi-arrow-right"></i></a>
            </div>
            <hr />
            <div class="row flex-nowrap overflow-auto scroll-custom px-2">
                @foreach ($popularProducts as $product)
                    <x-cards.product-popular :product="$product" />
                @endforeach
            </div>
        </div>
    </div>

    {{-- Produk Terbaru --}}
    <div class="row justify-content-center mt-5" style="padding:0 5vw;">
        <div class="col-12 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-bag"></i> PRODUCTS <span class="text-orange">TERBARU</span>
                </h6>
                <a href="/products" wire:navigate class="text-decoration-none text-orange fw-bold">Lihat Lainnya <i
                        class="bi bi-arrow-right"></i></a>
            </div>
            <hr />
            <div class="row">
                @foreach ($latestProducts as $product)
                    <x-cards.product :product="$product" />
                @endforeach
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