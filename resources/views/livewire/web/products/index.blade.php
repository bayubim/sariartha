@section('title')
Products - Sariartha Kue
@stop

@section('keywords')
Sariartha Kue
@stop

@section('description')
Sariartha Kue
@stop

@section('image')
{{ asset('images/logo.png') }}
@stop


<div class="container-fluid px-0" style="overflow:hidden; ">
    <div class="row justify-content-center">
        <div class="container-fluid px-3 px-md-5">

            <!-- <div class="bg-white rounded-bottom-custom shadow-sm p-3 sticky-top mb-4">
                <div class="d-flex justify-content-start">
                    <x-buttons.back />
                </div>
            </div> -->

            <div class="d-flex justify-content-between mt-4" style="padding:0 5vw;">
                <div>
                    <span class="fs-6 fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-bag mb-1" viewBox="0 0 16 16">
                            <path
                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                        </svg>
                        PRODUCTS
                    </span>
                </div>
            </div>
            <hr />

            <div class="row" style="padding:0 5vw;">
                <!-- <div class="col-12 col-md-12 mb-2"> -->
                @foreach ($products as $product)
                    <x-cards.product :product="$product" />
                @endforeach
                <!-- </div> -->
            </div>

            <!-- Navigasi Pagination -->
            {{ $products->links('vendor.pagination.simple-default') }}

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