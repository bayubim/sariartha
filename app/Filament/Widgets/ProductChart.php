<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductChart extends ApexChartWidget
{
    protected static ?string $chartId = 'productSalesChart';
    protected static ?string $heading = 'Grafik Penjualan Produk';
    protected int|string|array $columnSpan = '1';

    protected function getOptions(): array
    {
        // Ambil rentang tanggal dari transaksi (created_at di transactions)
        $startDate = Carbon::parse($this->filterFormData['date_start'] ?? now()->subMonth());
        $endDate = Carbon::parse($this->filterFormData['date_end'] ?? now())->endOfDay();

        // Query jumlah produk terjual berdasarkan transaction_details dengan status success di transactions
        $salesData = TransactionDetail::select(
            'products.title',
            DB::raw('SUM(transaction_details.qty) as total_qty')
        )
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->where('transactions.status', 'success')
            ->whereBetween('transactions.created_at', [$startDate, $endDate]) // Pakai rentang transaksi
            ->groupBy('products.title')
            ->orderByDesc('total_qty')
            ->get();

        // Warna acak untuk setiap produk
        $colors = [
            '#FF5733',
            '#33FF57',
            '#3357FF',
            '#F4C430',
            '#FF33A1',
            '#A133FF',
            '#33FFF5',
            '#FF8C33',
            '#33FFA1',
            '#FF3333'
        ];

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 250,
            ],
            'series' => [
                [
                    'name' => 'Jumlah Terjual',
                    'data' => $salesData->pluck('total_qty'),
                ],
            ],
            'xaxis' => [
                'categories' => $salesData->pluck('title'),
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'distributed' => true, // Warna berbeda untuk setiap bar
                ],
            ],
            'colors' => array_slice($colors, 0, count($salesData)), // Ambil warna sesuai jumlah produk
        ];
    }

    // Filter form untuk memilih rentang tanggal berdasarkan transactions.created_at
    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('date_start')
                ->label('Mulai Tanggal')
                ->default(now()->subMonth())
                ->reactive(),

            DatePicker::make('date_end')
                ->label('Sampai Tanggal')
                ->default(now())
                ->reactive(),
        ];
    }
}
