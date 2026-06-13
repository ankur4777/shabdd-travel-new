<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeasonalJourneyResource\Pages\CreateSeasonalJourney;
use App\Filament\Resources\SeasonalJourneyResource\Pages\EditSeasonalJourney;
use App\Filament\Resources\SeasonalJourneyResource\Pages\ListSeasonalJourneys;
use App\Models\SeasonalJourney;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SeasonalJourneyResource extends Resource
{
    protected static ?string $model = SeasonalJourney::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationLabel = 'Seasonal Journeys';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Card Details')->schema([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')->required(),
                FileUpload::make('image')->disk('public')->image()->directory('seasonal-journeys')->visibility('public'),
                TextInput::make('price_text'),
                Textarea::make('excerpt')->rows(3),
                Toggle::make('is_active')->default(true),
                TextInput::make('sort_order')->numeric()->default(0),
            ])->columns(2),

            Section::make('Hero & Overview')->schema([
                FileUpload::make('hero_image')
                    ->disk('public')
                    ->image()
                    ->directory('seasonal-journeys/hero')
                    ->visibility('public'),
                TextInput::make('tagline')
                    ->placeholder('Snow escapes, festive cities, and seasonal stays'),
                TextInput::make('location')
                    ->placeholder('India, Europe, Islands'),
                TextInput::make('best_season')
                    ->placeholder('November to February'),
                TextInput::make('ideal_duration')
                    ->placeholder('5-7 Days'),
                TextInput::make('climate')
                    ->placeholder('Cool, pleasant, beach-friendly'),
                TagsInput::make('popular_for')
                    ->placeholder('Honeymoon, Family, Snow, Beaches')
                    ->columnSpanFull(),
                RichEditor::make('overview')
                    ->columnSpanFull(),
                RichEditor::make('content')
                    ->label('Extra Content')
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Gallery')->schema([
                Repeater::make('gallery')
                    ->label('Gallery images')
                    ->schema([
                        FileUpload::make('image')
                            ->disk('public')
                            ->image()
                            ->directory('seasonal-journeys/gallery')
                            ->visibility('public')
                            ->required(),
                        Textarea::make('caption')
                            ->rows(2),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]),

            Section::make('Journey Highlights')->schema([
                Repeater::make('highlights')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('icon')
                            ->label('Bootstrap icon class')
                            ->placeholder('bi bi-stars'),
                        Textarea::make('description')
                            ->rows(2)
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]),

            Section::make('Why Choose Us')->schema([
                Textarea::make('why_choose_1')->rows(3),
                Textarea::make('why_choose_2')->rows(3),
                Textarea::make('why_choose_3')->rows(3),
                Textarea::make('why_choose_4')->rows(3),
            ])->columns(2),

            Section::make('Season Guide')->schema([
                Repeater::make('seasons')
                    ->label('Season guide cards')
                    ->schema([
                        TextInput::make('name')
                            ->label('Season name')
                            ->placeholder('Peak Season')
                            ->required(),
                        TextInput::make('icon')
                            ->label('Bootstrap icon class')
                            ->placeholder('bi bi-sun-fill'),
                        Textarea::make('weather')
                            ->label('Weather / short description')
                            ->rows(2)
                            ->required(),
                        TagsInput::make('activities')
                            ->label('Activities')
                            ->placeholder('Sightseeing, Outdoor tours, Local exploration')
                            ->columnSpanFull(),
                        Textarea::make('recommendation')->rows(2),
                        Textarea::make('packing_tip')->rows(2),
                        TextInput::make('crowd_level')
                            ->placeholder('High - book ahead'),
                        Textarea::make('highlight')->rows(2),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]),

            Section::make('Traveller Testimonials')->schema([
                Repeater::make('testimonials')
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('location'),
                        TextInput::make('rating')->numeric(),
                        Textarea::make('review')->rows(3),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]),

            Section::make('FAQs')->schema([
                Repeater::make('faqs')
                    ->schema([
                        TextInput::make('question')->required(),
                        Textarea::make('answer')->rows(3)->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]),

            Section::make('Limited Time Offer')->schema([
                TextInput::make('offer_title'),
                Textarea::make('offer_description')->rows(3),
                TextInput::make('discount_percentage'),
            ])->columns(2),

            Section::make('SEO')->schema([
                TextInput::make('meta_title'),
                Textarea::make('meta_description')->rows(3),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('sort_order')->label('Order')->sortable(),
                TextColumn::make('price_text')->label('Price'),
                IconColumn::make('is_active')->label('Active')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeasonalJourneys::route('/'),
            'create' => CreateSeasonalJourney::route('/create'),
            'edit' => EditSeasonalJourney::route('/{record}/edit'),
        ];
    }
}
