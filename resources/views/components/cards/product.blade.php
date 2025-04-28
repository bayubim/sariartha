<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card border-0 rounded shadow-sm h-100">
        <a href="/products/{{ $product->slug }}" class="text-decoration-none" wire:navigate>
            <img src="{{ asset('/storage/' . $product->image) }}" class="card-img-top object-fit-cover rounded-top"
                style="height: 200px; object-fit: cover;" alt="{{ $product->title }}">
        </a>
        <div class="card-body d-flex flex-column justify-content-between">
            <div>
                <a href="/products/{{ $product->slug }}" class="text-decoration-none text-dark" wire:navigate>
                    <h6 class="card-title mb-2">{{ $product->title }}</h6>
                </a>
                <p class="fw-bold text-success mb-2">Rp. {{ number_format($product->price) }}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-auto">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill text-orange me-2" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <span class="fw-bold">{{ number_format($product->ratings_avg_rating, 1) }}</span>
                </div>
                <div>
                    <livewire:web.cart.btn-add-to-cart :product_id="$product->id" />
                </div>
            </div>
        </div>
    </div>
</div>