<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <!-- Tombol Kembali -->
            <div class="d-flex mb-3">
                <x-buttons.back />
            </div>

            <!-- Informasi Pengiriman -->
            <div class="card border-0 shadow-sm rounded mb-3">
                <div class="card-body py-3 px-3">
                    <h6 class="fw-semibold text-orange mb-3">
                        <i class="bi bi-geo-alt-fill me-1"></i> Alamat Pengiriman
                    </h6>

                    <select class="form-select form-select-sm mb-2" wire:model.live="province_id">
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>

                    <select class="form-select form-select-sm mb-2" wire:model.live="city_id"
                        wire:key="{{ $province_id }}">
                        <option value="">-- Pilih Kota/Kabupaten --</option>
                        @foreach (\App\Models\City::where('province_id', $province_id)->get() as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>

                    <textarea class="form-control form-control-sm" rows="2" wire:model.live="address"
                        placeholder="Contoh: Jl. Kenanga No. 3, Tabanan, Bali"></textarea>
                </div>
            </div>

            <!-- Pilihan Pengiriman -->
            @if($city_id)
                <div class="card border-0 shadow-sm rounded mb-3">
                    <div class="card-body py-3 px-3">
                        <h6 class="fw-semibold text-orange mb-3">
                            <i class="bi bi-truck me-1"></i> Pilih Opsi Pengiriman
                        </h6>

                        <!-- Opsi Ambil di Tempat -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deliveryOption" id="pickupOption"
                                wire:click="togglePickupOption" value="pickup" {{ $pickupOption ? 'checked' : '' }}>
                            <label class="form-check-label small" for="pickupOption">
                                Ambil di Tempat (Gratis)
                            </label>
                        </div>

                        <!-- Opsi Kirim dengan Kurir -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="deliveryOption" id="courierOption"
                                wire:click="toggleCourierOption" value="courier" {{ !$pickupOption ? 'checked' : '' }}>
                            <label class="form-check-label small" for="courierOption">
                                Kirim dengan Kurir
                            </label>
                        </div>

                        <!-- Pilihan Kurir -->
                        @if(!$pickupOption) <!-- Menampilkan pilihan kurir hanya jika Kirim dengan Kurir dipilih -->
                            <div class="mt-3">
                                @foreach(['jne' => 'JNE', 'pos' => 'POS', 'tiki' => 'TIKI'] as $code => $label)
                                    <div class="form-check form-check-inline me-3">
                                        <input class="form-check-input" type="radio" name="courier" id="courier-{{ $code }}"
                                            wire:click="changeCourier('{{ $code }}')">
                                        <label class="form-check-label small" for="courier-{{ $code }}">{{ $label }}</label>
                                    </div>
                                @endforeach

                                <div class="text-center mt-3 mb-2">
                                    <div wire:loading wire:target="changeCourier">
                                        <div class="spinner-border spinner-border-sm text-warning" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="text-warning small mt-2">Mengambil data ongkir...</p>
                                    </div>
                                </div>

                                @if($showCost)
                                    <hr class="my-2">
                                    @foreach($costs ?? [] as $cost)
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="radio" name="cost"
                                                wire:click="getServiceAndCost('{{ $cost['cost'][0]['value'] }}|{{ $cost['service'] }}')">
                                            <label class="form-check-label small">
                                                {{ $cost['service'] }} - Rp {{ number_format($cost['cost'][0]['value'], 0, ',', '.') }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Total Pembayaran -->
            <div class="card border-0 shadow-sm rounded mb-3">
                <div class="card-body py-3 px-3">
                    <div class="row mb-3">
                        <div class="col">
                            <h6 class="fw-semibold text-orange">Total Harga</h6>
                            <p class="text-muted small">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                        </div>
                        <div class="col">
                            <h6 class="fw-semibold text-orange">Biaya Pengiriman</h6>
                            <p class="text-muted small">
                                @if($pickupOption)
                                    Gratis
                                @else
                                    Rp {{ number_format($selectCost, 0, ',', '.') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr class="my-2">
                    <div class="row mb-3">
                        <div class="col">
                            <h6 class="fw-semibold text-orange">Total Pembayaran</h6>
                            <h5 class="text-danger">Rp {{ number_format($grandTotal, 0, ',', '.') }}</h5>
                        </div>
                    </div>

                    @if($selectCost >= 0)
                        <hr style="border: dotted 1px #e92715;">

                        <livewire:web.checkout.btn-checkout key="{{ now() }}" :province_id="$province_id"
                            :city_id="$city_id" :address="$address" :grandTotal="$grandTotal" :totalWeight="$totalWeight"
                            :selectCourier="$selectCourier" :selectService="$selectService" :selectCost="$selectCost"
                            :pickupOption="$pickupOption" />
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>