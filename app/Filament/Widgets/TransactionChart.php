<?php
namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Widgets\ChartWidget;

class TransactionChart extends ChartWidget implements HasForms
{
    use InteractsWithForms;

    protected static ?string $heading = 'Grafik Transaksi';

    public ?array $formData = [];

    public function mount(): void
    {
        $this->formData = [
            'month' => Carbon::now()->month,
            'year' => Carbon::now()->year,
            'date' => Carbon::now()->toDateString(),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Bisa diubah ke 'line', 'pie', dll.
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('month')
                ->label('Bulan')
                ->options([
                    '1' => 'Januari',
                    '2' => 'Februari',
                    '3' => 'Maret',
                    '4' => 'April',
                    '5' => 'Mei',
                    '6' => 'Juni',
                    '7' => 'Juli',
                    '8' => 'Agustus',
                    '9' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember',
                ])
                ->default(Carbon::now()->month)
                ->reactive(),

            Select::make('year')
                ->label('Tahun')
                ->options(
                    array_combine(
                        range(Carbon::now()->year - 5, Carbon::now()->year),
                        range(Carbon::now()->year - 5, Carbon::now()->year)
                    )
                )
                ->default(Carbon::now()->year)
                ->reactive(),

            DatePicker::make('date')
                ->label('Tanggal')
                ->default(Carbon::now()->toDateString())
                ->reactive(),
        ];
    }

    protected function getData(): array
    {
        $filters = $this->formData;

        $query = Transaction::query();

        if (!empty($filters['month'])) {
            $query->whereMonth('created_at', $filters['month']);
        }

        if (!empty($filters['year'])) {
            $query->whereYear('created_at', $filters['year']);
        }

        if (!empty($filters['date'])) {
            $query->whereDate('created_at', Carbon::parse($filters['date'])->toDateString());
        }

        $salesData = $query->selectRaw('DAY(created_at) as day, COUNT(id) as total_transactions')
            ->groupBy('day')
            ->pluck('total_transactions', 'day')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Transaksi',
                    'data' => array_values($salesData),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                ],
            ],
            'labels' => array_keys($salesData),
        ];
    }
}