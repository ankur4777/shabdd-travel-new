<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages\CreateBlog;
use App\Filament\Resources\BlogResource\Pages\EditBlog;
use App\Filament\Resources\BlogResource\Pages\ListBlogs;
use App\Models\Blog;
use App\Models\Destination;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Blogs';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Blog Details')
                    ->schema([
                        Select::make('destination_id')
                            ->label('Destination')
                            ->options(fn () => Destination::query()->orderBy('name')->pluck('name', 'id')->all())
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->required(),

                        FileUpload::make('image')
                            ->disk('public')
                            ->image()
                            ->directory('blogs')
                            ->visibility('public'),

                        Select::make('category')
                            ->options([
                                'Destination Guide' => 'Destination Guide',
                                'Travel Tips' => 'Travel Tips',
                                'Budget Travel' => 'Budget Travel',
                                'Adventure' => 'Adventure',
                                'Honeymoon' => 'Honeymoon',
                                'Family Trips' => 'Family Trips',
                            ])
                            ->searchable(),

                        TextInput::make('reading_time')
                            ->numeric()
                            ->default(5),

                        DatePicker::make('published_at')
                            ->default(now()),

                        TextInput::make('author')
                            ->default('Shabdd Travel Team'),

                        TextInput::make('role')
                            ->default('Verified travel writer'),

                        Textarea::make('excerpt')
                            ->rows(3)
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->columnSpanFull(),

                        Toggle::make('is_featured')
                            ->label('Featured'),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Article Extra Content')
                    ->schema([
                        Repeater::make('highlights')
                            ->schema([
                                TextInput::make('text')
                                    ->required(),
                            ])
                            ->simple(TextInput::make('text'))
                            ->columnSpanFull(),

                        Repeater::make('quick_facts')
                            ->schema([
                                TextInput::make('label')
                                    ->required(),
                                TextInput::make('value')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Repeater::make('itinerary')
                            ->schema([
                                TextInput::make('day')
                                    ->placeholder('Day 1')
                                    ->required(),
                                Textarea::make('plan')
                                    ->rows(2)
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Repeater::make('faqs')
                            ->schema([
                                TextInput::make('question')
                                    ->required(),
                                Textarea::make('answer')
                                    ->rows(2)
                                    ->required(),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('destination.name')
                    ->label('Destination')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->badge(),
                TextColumn::make('published_at')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBlogs::route('/'),
            'create' => CreateBlog::route('/create'),
            'edit' => EditBlog::route('/{record}/edit'),
        ];
    }
}
