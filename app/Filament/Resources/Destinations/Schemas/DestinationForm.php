<?php

namespace App\Filament\Resources\Destinations\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
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

                        TextInput::make('price_from')
                            ->numeric()
                            ->required(),

                        TextInput::make('hero_subtitle'),

                        FileUpload::make('image_url')
                            ->image()
                            ->directory('destinations')
                            ->required(),

                        FileUpload::make('hero_image')
                            ->image()
                            ->directory('destinations'),

                    ]),

                Section::make('Gallery')
                    ->schema([
                        FileUpload::make('gallery')
                            ->multiple()
                            ->image()
                            ->directory('destinations/gallery')
                    ]),


                Section::make('Destination Overview')
                    ->schema([
                        RichEditor::make('overview')
                            ->columnSpanFull(),
                    ]),

                Section::make('Why Choose Us')
                    ->schema([
                        TextInput::make('why_choose_1'),
                        TextInput::make('why_choose_2'),
                        TextInput::make('why_choose_3'),
                        TextInput::make('why_choose_4'),
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
