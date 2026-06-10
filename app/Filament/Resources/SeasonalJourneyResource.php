<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeasonalJourneyResource\Pages;
use App\Models\SeasonalJourney;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class SeasonalJourneyResource extends Resource
{
    protected static ?string $model = SeasonalJourney::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map';
    protected static string|\UnitEnum|null $navigationGroup = 'Homepage';
    protected static ?string $navigationLabel = 'Seasonal Journeys';
    protected static ?int    $navigationSort  = 2;

    // ─── FORM ────────────────────────────────────────────────────────────────

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Destination Details')
                ->columns(2)
                ->schema([

                    TextInput::make('name')
                        ->label('Destination Name')
                        ->placeholder('ANDAMAN')
                        ->required()
                        ->maxLength(100),

                    TextInput::make('price')
                        ->label('Starting Price (₹)')
                        ->placeholder('14,999')
                        ->required()
                        ->helperText('Enter digits only, e.g. 14,999'),

                    TextInput::make('url')
                        ->label('Link URL')
                        ->placeholder('/packages/andaman')
                        ->default('#')
                        ->maxLength(255),

                    Select::make('card_size')
                        ->label('Card Layout Size')
                        ->options(SeasonalJourney::cardSizeOptions())
                        ->required()
                        ->helperText('Controls position & size in the bento grid'),

                    TextInput::make('sort_order')
                        ->label('Sort Order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower number = appears first'),

                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true)
                        ->inline(false),
                ]),

            Section::make('Card Image')
                ->schema([
                    FileUpload::make('image')
                        ->label('Destination Image')
                        ->image()
                        ->disk('public')
                        ->directory('seasonal-journeys')
                        ->imageAspectRatio('16:9')
                        ->automaticallyCropImagesToAspectRatio()
                        ->automaticallyResizeImagesToWidth('800')
                        ->required()
                        ->helperText('Recommended: 800×450px, JPG/WEBP'),
                ]),
        ]);
    }

    // ─── TABLE ───────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->width(80)
                    ->imageHeight(50)
                    ->circular(false),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('price')
                    ->label('Price (₹)')
                    ->formatStateUsing(fn($state) => '₹ ' . $state),

                TextColumn::make('card_size')
                    ->label('Layout')
                    ->badge()
                    ->formatStateUsing(fn($state) => SeasonalJourney::cardSizeOptions()[$state] ?? $state)
                    ->color('info'),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Active'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active only'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    // ─── PAGES ───────────────────────────────────────────────────────────────

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSeasonalJourneys::route('/'),
            'create' => Pages\CreateSeasonalJourney::route('/create'),
            'edit'   => Pages\EditSeasonalJourney::route('/{record}/edit'),
        ];
    }
}
