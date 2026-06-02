<?php

namespace App\Filament\Resources\Destinations\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;

class DestinationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([


                Section::make('Hero Section')
                    ->schema([

                        TextInput::make('name')
                            ->required(),

                        TextInput::make('slug')
                            ->required(),

                        TextInput::make('country')
                            ->required(),

                        Select::make('category')
                            ->label('Category')
                            ->options([
                                'Trending' => 'Trending',
                                'Popular' => 'Popular',
                                'Budget Friendly' => 'Budget Friendly',
                                'Premium' => 'Premium',
                            ]),

                        CheckboxList::make('travel_styles')
                            ->label('Travel style')
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
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        TextInput::make('price_from')
                            ->numeric()
                            ->required(),

                        TextInput::make('hero_subtitle'),

                        FileUpload::make('image_url')
                            ->disk('public')
                            ->image()
                            ->directory('destinations')
                            ->required(),

                        FileUpload::make('hero_image')
                            ->disk('public')
                            ->image()
                            ->directory('destinations'),

                    ]),

                Section::make('Gallery')
                    ->schema([
                        Repeater::make('gallery')
                            ->label('Gallery images')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Image')
                                    ->disk('public')
                                    ->image()
                                    ->directory('destinations/gallery')
                                    ->required(),

                                Textarea::make('caption')
                                    ->label('Text')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                    ]),


                Section::make('Destination Overview')
                    ->schema([
                        RichEditor::make('overview')
                            ->columnSpanFull(),
                    ]),

                Section::make('Why Choose Us')
                    ->schema([
                        Textarea::make('why_choose_1')
                            ->rows(3),
                        Textarea::make('why_choose_2')
                            ->rows(3),
                        Textarea::make('why_choose_3')
                            ->rows(3),
                        Textarea::make('why_choose_4')
                            ->rows(3),
                    ]),

                Section::make('Season Guide')
                    ->schema([
                        TextInput::make('best_season'),
                        // TextInput::make('weather'),
                        // TextInput::make('recommended_months'),
                    ]),
                Section::make('Traveller Testimonials')
                    ->schema([

                        Repeater::make('testimonials')
                            ->schema([

                                TextInput::make('name')
                                    ->required(),

                                TextInput::make('location'),

                                TextInput::make('rating'),

                                Textarea::make('review'),

                            ])

                    ]),
                Section::make('FAQs')
                    ->schema([

                        Repeater::make('faqs')
                            ->schema([

                                TextInput::make('question')
                                    ->required(),

                                Textarea::make('answer')
                                    ->required(),

                            ])

                    ]),

                Section::make('Quick Facts')
                    ->schema([
                        TextInput::make('location'),
                        TextInput::make('language'),
                        TextInput::make('currency'),
                        TextInput::make('ideal_duration'),
                    ]),

                Section::make('Limited Time Offer')
                    ->schema([
                        TextInput::make('offer_title'),
                        Textarea::make('offer_description'),
                        TextInput::make('discount_percentage'),
                    ]),

            ]);
    }
}
