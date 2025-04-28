<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\City;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CityChart extends ApexChartWidget
{
    protected static ?string $chartId = 'cityChart';
    protected static ?string $heading = 'Penjualan per Kota';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = '1';

    public ?array $data = [];

    protected function getOptions(): array
    {
        $startDate = Carbon::parse($this->filterFormData['date_start'] ?? now()->subYear());
        $endDate = Carbon::parse($this->filterFormData['date_end'] ?? now())->endOfDay();

        $transactions = Transaction::where('status', 'success')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('city_id, COUNT(*) as total')
            ->groupBy('city_id')
            ->get();

        $cityData = City::whereIn('id', $transactions->pluck('city_id'))->pluck('name', 'id');

        $this->data = $transactions->map(function ($trx) use ($cityData) {
            return [
                'name' => $cityData[$trx->city_id] ?? 'Unknown',
                'y' => (int) $trx->total,
            ];
        })->toArray();

        return [
            'chart' => [
                'type' => 'pie',
                'height' => '260', // responsive height
                'width' => '100%',  // responsive width
            ],
            'series' => array_column($this->data, 'y'),
            'labels' => array_column($this->data, 'name'),
            'colors' => ['#8b1e3f', '#ef767a', '#f5dd90', '#49beaa', '#456990'],
            'responsive' => [
                [
                    'breakpoint' => 768,
                    'options' => [
                        'chart' => [
                            'width' => '100%',
                            'height' => 280
                        ],
                        'legend' => [
                            'position' => 'bottom'
                        ]
                    ]
                ]
            ],
            'legend' => [
                'position' => 'right',
                'fontSize' => '14px',
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
