<?php

namespace App\Filament\Resources\PackageResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PackagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('travel_style')
                    ->badge(),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'domestic' => 'Domestic',
                        'international' => 'International',
                        default => 'Not set',
                    }),
                TextColumn::make('price'),
                IconColumn::make('featured')
                    ->boolean(),
                IconColumn::make('is_trending')
                    ->label('Trending')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
