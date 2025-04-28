<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialStockResource\Pages;
use App\Models\MaterialStock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MaterialStockResource extends Resource
{
    protected static ?string $model = MaterialStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Bahan')
                            ->placeholder('Contoh: Tepung Terigu')
                            ->required(),

                        Forms\Components\Grid::make(3)->schema([

                            Forms\Components\Select::make('unit')
                                ->label('Satuan')
                                ->options([
                                    'kg' => 'Kilogram (kg)',
                                    'gram' => 'Gram',
                                    'liter' => 'Liter',
                                    'ml' => 'Mililiter (ml)',
                                    'pcs' => 'Pieces (pcs)',
                                    'pack' => 'Pack',
                                ])
                                ->searchable()
                                ->required(),

                            Forms\Components\TextInput::make('quantity')
                                ->label('Jumlah')
                                ->numeric()
                                ->required(),

                            Forms\Components\TextInput::make('price')
                                ->label('Harga per Satuan')
                                ->prefix('Rp')
                                ->numeric()
                                ->required(),
                        ]),

                        Forms\Components\Textarea::make('description')
                            ->label('Keterangan')
                            ->placeholder('Keterangan tambahan (opsional)')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Bahan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('unit')
                    ->label('Satuan'),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jumlah'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id'),

                Tables\Columns\TextColumn::make('total_value')
                    ->label('Total Nilai')
                    ->getStateUsing(fn($record) => $record->total_value)
                    ->money('IDR', locale: 'id'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterialStocks::route('/'),
            'create' => Pages\CreateMaterialStock::route('/create'),
            'edit' => Pages\EditMaterialStock::route('/{record}/edit'),
        ];
    }
}
