<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TextInputFilter;
use Filament\Forms\Components\DatePicker;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Carts & Orders';

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function canCreate(): bool
    {
        return false; // Disable create functionality
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'expired' => 'Expired',
                        'failed' => 'Failed',
                        'process' => 'Process',
                        'delivery' => 'Delivery',
                    ])
                    ->required()
                    ->default('pending'), // Default to 'pending'
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice')->searchable(),
                Tables\Columns\TextColumn::make('customer.name')->searchable(),
                Tables\Columns\TextColumn::make('total')->money('IDR', locale: 'id')->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'expired' => 'gray',
                        'failed' => 'danger',
                        'process' => 'info',
                        'delivery' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                // Filter status
                SelectFilter::make('status')
                    ->label('Status Transaksi')
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'expired' => 'Expired',
                        'failed' => 'Failed',
                        'process' => 'Process',
                        'delivery' => 'Delivery',
                    ]),

                // Filter tanggal transaksi
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),

                // Filter nama pelanggan
                Filter::make('customer')
                    ->form([
                        Forms\Components\TextInput::make('customer_name')->label('Nama Pelanggan'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['customer_name'], fn($q) => $q->whereHas('customer', function ($subQuery) use ($data) {
                                $subQuery->where('name', 'like', '%' . $data['customer_name'] . '%');
                            }));
                    }),


            ])
            ->actions([
                EditAction::make()
                    ->label('Edit Status')
                    ->form(fn(Transaction $record) => [
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'success' => 'Success',
                                'expired' => 'Expired',
                                'failed' => 'Failed',
                                'process' => 'Process',
                                'delivery' => 'Delivery',
                            ])
                            ->default($record->status)
                            ->required()
                    ])
                    ->modalHeading('Edit Transaction Status')
                    ->modalSubheading('Update the status of the transaction'),
            ])
            ->bulkActions([
                // Optional bulk actions
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relationships if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            // Disable the full edit page, since inline edit is enough
            //'edit' => Pages\EditTransaction::route('/{record}/edit'), 
        ];
    }
}
