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
use Filament\Forms\Components\Repeater;
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
                            ->disk('public')
                            ->directory('packages')
                            ->visibility('public')
                            ->required(),

                        Select::make('category')
                            ->options([
                                'Trending' => 'Trending',
                                'Popular' => 'Popular',
                                'Budget Friendly' => 'Budget Friendly',
                                'Premium' => 'Premium',
                            ])
                            ->required(),
                        Select::make('type')
                            ->options([
                                'Domestic' => 'Domestic',
                                'International' => 'International',
                            ]),

                        Select::make('travel_style')
                            ->options([
                                'honeymoon' => 'Honeymoon',
                                'religiuos' => 'Religious',
                                'family' => 'Family',
                                'adventure' => 'Adventure',
                                'friends' => 'Friends',
                                'solo' => 'Solo',
                                'nature' => 'Nature',
                                'wildlife' => 'Wildlife',
                                'water activities' => 'Water Activities',

                            ]),

                        TextInput::make('days')
                            ->numeric(),
                        TextInput::make('country'),
                        TextInput::make('state'),
                        TextInput::make('city'),

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

                Section::make('Package Detail Page Content')
                    ->schema([
                        RichEditor::make('detail_overview')
                            ->label('Package overview')
                            ->helperText('Shown in the Package Overview section. If empty, the package description is used.')
                            ->columnSpanFull(),

                        FileUpload::make('detail_gallery')
                            ->label('Detail page gallery')
                            ->disk('public')
                            ->directory('packages/gallery')
                            ->visibility('public')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->columnSpanFull(),

                        FileUpload::make('pdf_file')
                            ->label('Package PDF')
                            ->disk('public')
                            ->directory('packages/pdfs')
                            ->visibility('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),

                        Repeater::make('detail_highlights')
                            ->label('Overview highlight badges')
                            ->simple(TextInput::make('highlight'))
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Hotel Details')
                    ->schema([
                        TextInput::make('hotel_name'),

                        TextInput::make('hotel_category')
                            ->placeholder('4 Star Hotel'),

                        TextInput::make('hotel_area')
                            ->placeholder('Central Area'),

                        FileUpload::make('hotel_image')
                            ->disk('public')
                            ->directory('packages/hotels')
                            ->visibility('public')
                            ->image(),

                        Repeater::make('hotel_highlights')
                            ->simple(TextInput::make('highlight'))
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Day Wise Itinerary')
                    ->schema([
                        Repeater::make('itinerary')
                            ->schema([
                                TextInput::make('day')
                                    ->numeric()
                                    ->placeholder('1'),
                                TextInput::make('title')
                                    ->required(),
                                Textarea::make('summary')
                                    ->rows(3)
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('Inclusions / Exclusions')
                    ->schema([
                        Repeater::make('inclusions')
                            ->simple(TextInput::make('item'))
                            ->columnSpanFull(),

                        Repeater::make('exclusions')
                            ->simple(TextInput::make('item'))
                            ->columnSpanFull(),
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
