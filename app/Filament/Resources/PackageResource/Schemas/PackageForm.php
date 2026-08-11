<?php

namespace App\Filament\Resources\PackageResource\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;

use Filament\Schemas\Components\Section;

use Illuminate\Support\Str;

class PackageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Package Details')
                    ->schema([

                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn ($state, callable $set) =>
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
                                'corporate tour' => 'Corporate Tour',
                            ]),

                        Select::make('type')
                            ->options([
                                'domestic' => 'Domestic',
                                'international' => 'International',
                            ])
                            ->default('domestic')
                            ->required()
                            ->native(false),

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
                                'Hill' => 'Hill',
                                'Island' => 'Island',
                                'Desert' => 'Desert',
                            ]),

                        Textarea::make('feature_1'),

                        Textarea::make('feature_2'),

                        Textarea::make('feature_3'),

                        RichEditor::make('description'),

                        Toggle::make('featured'),

                        Toggle::make('is_trending')
                            ->label('Trending')
                            ->helperText('Show this package in the homepage trending packages section.'),

                    ])
                    ->columns(2),

                Section::make('FAQs')
                    ->schema([
                        Repeater::make('faqs')
                            ->schema([
                                TextInput::make('question')
                                    ->required(),

                                Textarea::make('answer')
                                    ->rows(3)
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),

            ]);
    }
}
