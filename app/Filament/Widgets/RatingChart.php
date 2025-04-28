<?php

namespace App\Filament\Widgets;

use App\Models\Rating;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class RatingChart extends ApexChartWidget
{
    protected static ?string $chartId = 'productRatingChart';
    protected static ?string $heading = 'Rata-rata Rating Produk';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = '1';

    protected function getOptions(): array
    {
        $startDate = Carbon::parse($this->filterFormData['date_start'] ?? now()->subMonth());
        $endDate = Carbon::parse($this->filterFormData['date_end'] ?? now())->endOfDay();
        $filterType = $this->filterFormData['rating_filter'] ?? 'all';

        $ratingsQuery = Rating::select(
            'products.title',
            DB::raw('AVG(ratings.rating) as avg_rating')
        )
            ->join('products', 'ratings.product_id', '=', 'products.id')
            ->whereBetween('ratings.created_at', [$startDate, $endDate])
            ->groupBy('products.title');

        if ($filterType === 'best') {
            $ratingsQuery->orderByDesc('avg_rating');
        } elseif ($filterType === 'worst') {
            $ratingsQuery->orderBy('avg_rating');
        }

        $ratings = $ratingsQuery->get();

        $colors = ['#F97316', '#3B82F6', '#10B981', '#8B5CF6', '#EF4444', '#FACC15', '#14B8A6', '#6366F1', '#EC4899', '#84CC16'];

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 250,
            ],
            'series' => [
                [
                    'name' => 'Rata-rata Rating',
                    'data' => $ratings->pluck('avg_rating')->map(fn($val) => round($val, 2)),
                ],
            ],
            'xaxis' => [
                'categories' => $ratings->pluck('title'),
                'labels' => [
                    'style' => [
                        'colors' => '#6B7280',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'min' => 0,
                'max' => 5,
                'labels' => [
                    'style' => [
                        'colors' => '#6B7280',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'plotOptions' => [
                'bar' => [
                    'distributed' => true,
                ],
            ],
            'colors' => array_slice($colors, 0, count($ratings)),
        ];
    }

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

            Select::make('rating_filter')
                ->label('Filter Rating')
                ->options([
                    'all' => 'Semua',
                    'best' => 'Rating Terbaik',
                    'worst' => 'Rating Terburuk',
                ])
                ->default('all')
                ->reactive(),
        ];
    }
}
