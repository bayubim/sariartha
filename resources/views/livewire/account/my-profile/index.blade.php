<div class="container-fluid px-0 pt-5 mt-4">
    <div class="row justify-content-center mt-0" style="margin-bottom: 150px; padding:0 5vw;">
        <div class="col-12 col-md-8 col-lg-6">

            <x-menus.customer />

            <div class="bg-white rounded shadow-lg p-4">
                <h6 class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-person mb-1 me-2" viewBox="0 0 16 16">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                    My Profile
                </h6>
                <hr class="my-2" />

                <form wire:submit.prevent="update">

                    <!-- Profile Image Upload -->
                    <div class="mb-3">
                        <label class="form-label" for="image">Profile Image</label>
                        <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror"
                            id="image" placeholder="Upload Image">
                        @error('image')
                            <div class="alert alert-danger mt-2 rounded border-0">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Name Input -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Full Name</label>
                        <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" placeholder="Enter your full name">
                        @error('name')
                            <div class="alert alert-danger mt-2 rounded border-0">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Phone Number Input -->
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input type="text" wire:model="phone" class="form-control @error('phone') is-invalid @enderror"
                            id="phone" placeholder="Enter your phone number">
                        @error('phone')
                            <div class="alert alert-danger mt-2 rounded border-0">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="Enter your email address">
                        @error('email')
                            <div class="alert alert-danger mt-2 rounded border-0">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Update Button -->
                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2">Update Profile</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4 shadow-lg mt-5 w-100" style="padding:0 5vw;">
        <div class="container-fluid px-4 px-md-5">
            <div class="row">
                <!-- Tentang Kami -->
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold">Tentang Kami</h6>
                    <p class="small">
                        Sariartha Kue menyediakan jajanan tradisional Indonesia dengan cita rasa khas dan berkualitas.
                        Dukung UMKM lokal!
                    </p>
                </div>

                <!-- Navigasi dan Kontak -->
                <div class="col-md-7 offset-md-1 mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h6 class="fw-bold">Navigasi</h6>
                            <ul class="list-unstyled small">
                                <li><a href="/" class="text-decoration-none text-white-50" wire:navigate>Home</a></li>
                                <li><a href="/products" class="text-decoration-none text-white-50"
                                        wire:navigate>Produk</a></li>
                                <li><a href="/cart" class="text-decoration-none text-white-50"
                                        wire:navigate>Keranjang</a></li>
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

            <hr class="border-light" />

            <div class="text-center small text-white-50">
                &copy; {{ date('Y') }} Sariartha Kue. All rights reserved.
            </div>
        </div>
    </footer>
</div>