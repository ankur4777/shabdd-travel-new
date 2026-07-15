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
use Filament\Forms\Components\TagsInput;

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

                        Select::make('type')
                            ->label('Destination Type')
                            ->options([
                                'domestic' => 'Domestic',
                                'international' => 'International',
                            ])
                            ->default('domestic')
                            ->required()
                            ->native(false),

                        Select::make('category')
                            ->label('Category')
                            ->options([
                                'Trending' => 'Trending',
                                'Popular' => 'Popular',
                                'Budget Friendly' => 'Budget Friendly',
                                'Premium' => 'Premium',
                            ]),

                        Select::make('theme')
                            ->label('Theme')
                            ->required()
                            ->options([
                                'Beach' => 'Beach',
                                'Hill' => 'Hill',
                                'Island' => 'Island',
                                'Desert' => 'Desert',
                            ]),

                        CheckboxList::make('travel_styles')
                            ->label('Travel style')
                            ->options([
                                'honeymoon' => 'Honeymoon',
                                'religiuos' => 'Religious',
                                'family' => 'Family',
                                'adventure' => 'Adventure',
                                'friends' => 'Friends',
                                'corporate tour' => 'Corporate Tour',
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

                        Textarea::make('hero_description')
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('hero_primary_text')
                            ->label('Primary button text'),

                        TextInput::make('hero_primary_url')
                            ->label('Primary button URL')
                            ->url(),

                        TextInput::make('hero_secondary_text')
                            ->label('Secondary button text'),

                        TextInput::make('hero_secondary_url')
                            ->label('Secondary button URL')
                            ->url(),

                        FileUpload::make('image_url')
                            ->disk('public')
                            ->image()
                            ->directory('destinations')
                            ->visibility('public')
                            ->required(),

                        FileUpload::make('hero_image')
                            ->disk('public')
                            ->image()
                            ->directory('destinations')
                            ->visibility('public'),

                        FileUpload::make('hero_video')
                            ->label('Hero background video')
                            ->disk('public')
                            ->directory('destinations/videos')
                            ->visibility('public')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                            ->maxSize(51200),

                        Repeater::make('hero_cards')
                            ->label('Floating destination cards')
                            ->helperText('Add up to 3 cards. Empty cards are not shown on the destination page.')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Card image')
                                    ->disk('public')
                                    ->storeFiles()
                                    ->image()
                                    ->directory('destinations/hero-cards')
                                    ->visibility('public'),
                                TextInput::make('title')
                                    ->required(),
                                TextInput::make('badge')
                                    ->label('Badge / subtitle'),
                                Textarea::make('description')
                                    ->rows(2),
                                TextInput::make('rating')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(5),
                                TextInput::make('url')
                                    ->label('Card link')
                                    ->url(),
                            ])
                            ->columns(2)
                            ->maxItems(3)
                            ->columnSpanFull(),

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
                                    ->visibility('public')
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
                        TagsInput::make('popular_for')
                            ->label('Popular for')
                            ->placeholder('Culture, Scenic Views, Local Experiences')
                            ->columnSpanFull(),
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
                                Textarea::make('recommendation')
                                    ->rows(2),
                                Textarea::make('packing_tip')
                                    ->rows(2),
                                TextInput::make('crowd_level')
                                    ->placeholder('High - book ahead'),
                                Textarea::make('highlight')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
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

                                FileUpload::make('image')
                                    ->label('Profile Image')
                                    ->helperText('Upload the traveller profile photo shown beside the testimonial name.')
                                    ->disk('public')
                                    ->directory('review-profiles')
                                    ->visibility('public')
                                    ->image(),

                                FileUpload::make('images')
                                    ->label('Review Images')
                                    ->helperText('Upload up to 5 images for this testimonial.')
                                    ->disk('public')
                                    ->directory('review-images')
                                    ->visibility('public')
                                    ->image()
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->reorderable()
                                    ->columnSpanFull(),

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
