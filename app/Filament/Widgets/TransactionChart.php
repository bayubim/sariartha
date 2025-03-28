<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\DatePicker;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class TransactionChart extends ApexChartWidget
{
    protected static ?string $chartId = 'transactionChart';
    protected static ?string $heading = 'Grafik Transaksi';
    protected int|string|array $columnSpan = '1';
    // protected static ?string $footer = 'Tanggal';

    protected function getOptions(): array
    {
        // Ambil rentang tanggal dari filter
        $startDate = Carbon::parse($this->filterFormData['date_start'] ?? now()->subYear());
        $endDate = Carbon::parse($this->filterFormData['date_end'] ?? now())->endOfDay();

        // Cek apakah dalam satu bulan
        $isOneMonth = $startDate->copy()->startOfMonth()->equalTo($endDate->copy()->startOfMonth());

        // Ambil data transaksi sukses dalam rentang waktu yang dipilih
        $data = Trend::query(
                    Transaction::where('status', 'success')
                )
                    ->between(start: $startDate, end: $endDate)
            ->{$isOneMonth ? 'perDay' : 'perMonth'}()
                ->sum('total');

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Total Transaksi',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'xaxis' => [
                'categories' => $data->map(
                    fn(TrendValue $value) =>
                    Carbon::parse($value->date)->format($isOneMonth ? 'd M Y' : 'M Y')
                ),
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 200,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 200,
                    ],
                ],
            ],
            'colors' => ['#4CAF50'],
            'stroke' => [
                'curve' => 'straight',
                'width' => 3,
            ],
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('date_start')
                ->label('Mulai Tanggal')
                ->default(now()->subYear())
                ->reactive(),

            DatePicker::make('date_end')
                ->label('Sampai Tanggal')
                ->default(now())
                ->reactive(),
        ];
    }
}
