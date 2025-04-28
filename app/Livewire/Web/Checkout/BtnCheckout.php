<?php

namespace App\Livewire\Web\Checkout;

use Midtrans\Snap;
use App\Models\Cart;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class BtnCheckout extends Component
{
    public $province_id;
    public $city_id;
    public $address;

    public $selectCourier;
    public $selectService;
    public $selectCost;

    public $totalWeight;
    public $grandTotal;
    public $pickupOption;

    public $response;
    public $loading;

    public function __construct()
    {
        // Set konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    public function mount(
        $selectCourier = null,
        $selectService = null,
        $selectCost = null,
        $pickupOption = false
    ) {
        $this->selectCourier = $selectCourier;
        $this->selectService = $selectService;
        $this->selectCost = $selectCost;
        $this->pickupOption = $pickupOption;
    }

    public function storeCheckout()
    {
        $this->loading = true;

        $customer = auth()->guard('customer')->user();

        // Validasi dasar
        if (!$customer || !$this->province_id || !$this->city_id || !$this->address || !$this->grandTotal) {
            session()->flash('error', 'Data tidak lengkap. Silakan periksa kembali.');
            $this->loading = false;
            return;
        }

        try {
            DB::transaction(function () use ($customer) {
                $invoice = 'INV-' . mt_rand(1000, 9999);

                $transaction = Transaction::create([
                    'customer_id' => $customer->id,
                    'invoice' => $invoice,
                    'province_id' => $this->province_id,
                    'city_id' => $this->city_id,
                    'address' => $this->address,
                    'weight' => $this->totalWeight,
                    'total' => $this->grandTotal,
                    'status' => 'PENDING',
                ]);

                // Tentukan detail pengiriman
                $shippingCourier = $this->pickupOption ? 'pickup' : $this->selectCourier;
                $shippingService = $this->pickupOption ? 'Ambil di Tempat' : $this->selectService;
                $shippingCost = $this->pickupOption ? 0 : $this->selectCost;

                $transaction->shipping()->create([
                    'shipping_courier' => $shippingCourier,
                    'shipping_service' => $shippingService,
                    'shipping_cost' => $shippingCost,
                ]);

                $item_details = [];
                $carts = Cart::where('customer_id', $customer->id)->with('product')->get();

                foreach ($carts as $cart) {
                    $transaction->transactionDetails()->create([
                        'product_id' => $cart->product->id,
                        'qty' => $cart->qty,
                        'price' => $cart->product->price,
                    ]);

                    $item_details[] = [
                        'id' => $cart->product->id,
                        'price' => $cart->product->price,
                        'quantity' => $cart->qty,
                        'name' => $cart->product->title,
                    ];
                }

                // Tambahkan biaya pengiriman jika bukan pickup
                if (!$this->pickupOption) {
                    $item_details[] = [
                        'id' => 'shipping',
                        'price' => $this->selectCost,
                        'quantity' => 1,
                        'name' => 'Ongkos Kirim: ' . $this->selectCourier . ' - ' . $this->selectService,
                    ];
                }

                Cart::where('customer_id', $customer->id)->delete();

                // Payload untuk Midtrans
                $payload = [
                    'transaction_details' => [
                        'order_id' => $invoice,
                        'gross_amount' => $this->grandTotal,
                    ],
                    'customer_details' => [
                        'first_name' => $customer->name,
                        'email' => $customer->email,
                        'shipping_address' => $this->address,
                    ],
                    'item_details' => $item_details,
                ];

                // Dapatkan token snap Midtrans
                $snapToken = Snap::getSnapToken($payload);

                // Simpan snap token ke transaksi
                $transaction->snap_token = $snapToken;
                $transaction->save();

                // Simpan respons snap token
                $this->response['snap_token'] = $snapToken;

                // Set loading
                $this->loading = false;
            });

            // Flash session dan redirect
            session()->flash('success', 'Silahkan lakukan pembayaran untuk melanjutkan proses checkout.');
            return $this->redirect('/account/my-orders/' . $this->response['snap_token'], navigate: true);

        } catch (\Exception $e) {
            // Tangani error
            session()->flash('error', 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi.');

            // Set loading
            $this->loading = false;
            return;
        }
    }

    public function render()
    {
        return view('livewire.web.checkout.btn-checkout');
    }
}