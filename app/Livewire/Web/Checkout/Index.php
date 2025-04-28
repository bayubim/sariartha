<?php
namespace App\Livewire\Web\Checkout;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Province;
use Illuminate\Support\Facades\Http;

class Index extends Component
{
    public $address;
    public $province_id;
    public $city_id;

    public $loading = false;
    public $showCost = false;
    public $costs;

    public $selectCourier = ''; // Selected Courier (JNE, POS, TIKI)
    public $selectService = ''; // Selected Service
    public $selectCost = 0; // Shipping cost
    public $grandTotal = 0; // Grand total price including shipping
    public $selectedCourier;
    public $courierOption = false;
    public $pickupOption = false; // Opsi ambil di tempat

    /**
     * Change the selected courier or pickup option.
     *
     * @param string $courier
     * @return void
     */
    public function changeCourier($courier)
    {
        $this->selectedCourier = $courier;

        if ($courier == 'pickup') {
            // Set opsi pengiriman menjadi 'Ambil di Tempat'
            $this->pickupOption = true;
            $this->selectCourier = ''; // Reset selected courier
        } else {
            // Set opsi pengiriman menjadi kirim dengan kurir
            $this->pickupOption = false;
            $this->selectCourier = $courier; // Set selected courier
        }

        // Perbarui biaya pengiriman jika diperlukan
        $this->CheckOngkir();
    }

    /**
     * Get cart data including total weight and total price.
     *
     * @return array
     */
    public function getCartsData()
    {
        $carts = Cart::query()
            ->with('product')
            ->where('customer_id', auth()->guard('customer')->user()->id)
            ->latest()
            ->get();

        $totalWeight = $carts->sum(function ($cart) {
            return $cart->product->weight * $cart->qty;
        });

        $totalPrice = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->qty;
        });

        return [
            'totalWeight' => $totalWeight,
            'totalPrice' => $totalPrice,
        ];
    }

    /**
     * Calculate shipping cost using the RajaOngkir API.
     *
     * @return void
     */
    public function CheckOngkir()
    {
        try {
            // Jika opsi ambil di tempat dipilih, set biaya 0 dan langsung keluar dari fungsi
            if ($this->pickupOption) {
                $this->costs = []; // Kosongkan biaya ongkir
                $this->selectCost = 0;
                return;
            }

            // Ambil data cart
            $cartData = $this->getCartsData();

            // Fetch data from RajaOngkir API
            $response = Http::withHeaders([
                'key' => config('rajaongkir.api_key')
            ])->post('https://api.rajaongkir.com/starter/cost', [
                        'origin' => 17, // ID kota Demak
                        'destination' => $this->city_id,
                        'weight' => $cartData['totalWeight'],
                        'courier' => $this->selectCourier,
                    ]);

            // Check if response is valid
            if ($response->successful()) {
                $this->costs = $response['rajaongkir']['results'][0]['costs'];
            } else {
                $this->costs = []; // Reset if API request fails
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal mengambil ongkir.');
            $this->costs = [];
        } finally {
            $this->loading = false;
            $this->showCost = true;
        }
    }

    /**
     * Set the selected shipping service and cost.
     *
     * @param string $data
     * @return void
     */
    public function getServiceAndCost($data)
    {
        // Pecah data menjadi nilai cost dan service
        [$cost, $service] = explode('|', $data);

        // Set nilai cost dan service
        $this->selectCost = (int) $cost;
        $this->selectService = $service;

        // Ambil total harga dari cart
        $cartData = $this->getCartsData();

        // Hitung grand total
        $this->grandTotal = $cartData['totalPrice'] + $this->selectCost;
    }

    /**
     * Toggle Pickup Option (Ambil di Tempat).
     *
     * @return void
     */
    public function togglePickupOption()
    {
        $this->pickupOption = !$this->pickupOption;
        if ($this->pickupOption) {
            // Set biaya 0 jika opsi ambil di tempat dipilih
            $this->selectCost = 0;
            $this->grandTotal = $this->getCartsData()['totalPrice'];
        } else {
            // Reset cost jika opsi ambil di tempat dibatalkan
            $this->CheckOngkir();
        }
    }

    /**
     * Render the checkout page.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $provinces = Province::query()->get();
        $cartData = $this->getCartsData();
        $totalPrice = $cartData['totalPrice'];
        $totalWeight = $cartData['totalWeight'];

        return view('livewire.web.checkout.index', compact('provinces', 'totalPrice', 'totalWeight'));
    }
}
