<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-5">
                <h4 class="text-center mb-3 fw-bold text-primary">Register</h4>
                <p class="text-muted text-center mb-4">Create your account</p>

                <form wire:submit.prevent="register">
                    <!-- Full Name -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" wire:model.blur="name" value="{{ old('name') }}"
                                class="form-control border-start-0 @error('name') is-invalid @enderror"
                                placeholder="Full Name">
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-phone"></i>
                            </span>
                            <input type="text" wire:model.blur="phone" value="{{ old('phone') }}"
                                class="form-control border-start-0 @error('phone') is-invalid @enderror"
                                placeholder="Phone Number">
                        </div>
                        @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" wire:model.blur="email" value="{{ old('email') }}"
                                class="form-control border-start-0 @error('email') is-invalid @enderror"
                                placeholder="Email">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" wire:model.blur="password"
                                class="form-control border-start-0 @error('password') is-invalid @enderror"
                                placeholder="Password">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-shield-lock"></i>
                            </span>
                            <input type="password" wire:model.blur="password_confirmation"
                                class="form-control border-start-0" placeholder="Confirm Password">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn w-100 rounded-pill fw-semibold text-white"
                        style="background-color: #5dade2;">
                        <i class="bi bi-person-plus me-1"></i> Register
                    </button>
                </form>

                <div class="text-center mt-4">
                    <small class="text-muted">Already have an account?</small>
                    <a href="/login" class="fw-bold text-decoration-none ms-1 text-primary" wire:navigate>
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>