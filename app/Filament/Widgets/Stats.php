<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Stats extends BaseWidget
{
    protected ?string $heading = 'Total Pendapatan';
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        $totalIncome = Transaction::where('status', 'success')->sum('total');

        return [
            Card::make('Pendapatan Keseluruhan', 'Rp ' . number_format($totalIncome, 0, ',', '.'))
                ->description('Dari semua transaksi sukses')
                ->color('success')
                ->chart([1, 5, 20, 50, 100, 200, 300, 400, 500]),
            Card::make('Pendapatan Keseluruhan', 'Rp ' . number_format($totalIncome, 0, ',', '.'))
                ->description('Dari semua transaksi sukses')
                ->color('success')
                ->chart([1, 5, 20, 50, 100, 200, 300, 400, 500]),
            Card::make('Pendapatan Keseluruhan', 'Rp ' . number_format($totalIncome, 0, ',', '.'))
                ->description('Dari semua transaksi sukses')
                ->color('success')
                ->chart([1, 5, 20, 50, 100, 200, 300, 400, 500]),
        ];
    }
}
