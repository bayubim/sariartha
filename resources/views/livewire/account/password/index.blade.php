<div class="container-fluid px-0">
    <div class="row justify-content-center mt-0"
        style="margin-bottom: 150px; margin-top: 50px !important; padding:0 5vw;">
        <div class="container-fluid px-3 px-md-5">

            <x-menus.customer />

            <div class="card border-0 shadow-sm rounded">
                <div class="card-body p-4">
                    <h6>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                            class="bi bi-key mb-1" viewBox="0 0 16 16">
                            <path
                                d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8m4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5" />
                            <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                        </svg>
                        Update Password
                    </h6>
                    <hr />

                    <form wire:submit.prevent="update">

                        <div class="input-group mb-3">
                            <input type="password" wire:model="password"
                                class="form-control rounded @error('password') is-invalid @enderror"
                                value="{{ old('password') }}" placeholder="New Password">
                        </div>
                        @error('password')
                            <div class="alert alert-danger mt-2 rounded border-0">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="input-group mb-3">
                            <input type="password" wire:model="password_confirmation" class="form-control rounded"
                                placeholder="Confirm Password">
                        </div>

                        <button class="btn btn-orange-2 rounded" type="submit">Update Password</button>

                    </form>

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