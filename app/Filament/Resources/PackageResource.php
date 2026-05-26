<?php

namespace App\Filament\Resources;

use BackedEnum;

use App\Models\Package;

use Filament\Forms;
use Filament\Schemas\Schema;


use App\Filament\Resources\PackageResource\Pages;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Resources\Resource;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;

use Illuminate\Support\Str;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Package Details')
                    ->schema([

                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn($state, callable $set) =>
                                $set('slug', Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->required(),

                        FileUpload::make('image')
                            ->image()
                            ->directory('packages'),

                        Select::make('category')
                            ->options([
                                'Luxury' => 'Luxury',
                                'Budget' => 'Budget',
                                'Premium' => 'Premium',
                            ]),

                        Select::make('travel_style')
                            ->options([
                                'honeymoon' => 'Honeymoon',
                                'pilgrimage' => 'Pilgrimage',
                                'family' => 'Family',
                                'adventure' => 'Adventure',
                            ]),

                        TextInput::make('days')
                            ->numeric(),

                        TextInput::make('duration_text'),

                        TextInput::make('rating')
                            ->numeric(),

                        TextInput::make('price')
                            ->numeric(),

                        TextInput::make('old_price')
                            ->numeric(),

                        Select::make('flight')
                            ->options([
                                'included' => 'Included',
                                'excluded' => 'Excluded',
                            ]),

                        Select::make('theme')
                            ->options([
                                'Beach' => 'Beach',
                                'Mountain' => 'Mountain',
                                'Island' => 'Island',
                            ]),

                        Textarea::make('feature_1'),

                        Textarea::make('feature_2'),

                        Textarea::make('feature_3'),

                        RichEditor::make('description')
                            ->columnSpanFull(),

                        Toggle::make('featured'),

                    ])
                    ->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('image'),

                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('travel_style')
                    ->badge(),

                TextColumn::make('price'),

                TextColumn::make('rating'),

                IconColumn::make('featured')
                    ->boolean(),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
