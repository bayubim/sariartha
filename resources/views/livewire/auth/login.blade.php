<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <h3 class="text-center mb-4 fw-bold" style="color: #5dade2;">Welcome Back</h3>
                <p class="text-muted text-center mb-4">Login to your account</p>

                <form wire:submit.prevent="login">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope"></i></span>
                            <input type="email" wire:model.blur="email" value="{{ old('email') }}"
                                class="form-control border-start-0 @error('email') is-invalid @enderror"
                                placeholder="you@example.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock"></i></span>
                            <input type="password" wire:model.blur="password"
                                class="form-control border-start-0 @error('password') is-invalid @enderror"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn w-100 rounded-pill fw-semibold text-white" type="submit"
                        style="background-color: #5dade2;">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </button>
                </form>

                <div class="text-center mt-4">
                    <span class="text-muted">Don't have an account?</span>
                    <a href="/register" class="fw-bold text-decoration-none ms-1" style="color: #5dade2;" wire:navigate>
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>