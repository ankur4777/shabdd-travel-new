<?php

namespace App\Filament\Resources\Pages;

use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

namespace App\Filament\Resources\Pages;

use App\Models\Page;

use Filament\Resources\Resource;
use Filament\Tables\Table;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use Filament\Forms\Components\RichEditor;
use BackedEnum;

use App\Filament\Resources\Pages\Pages;
use App\Filament\Resources\Pages\Tables\PagesTable;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Page Details')
                    ->schema([

                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn($state, callable $set) =>
                                $set('slug', \Illuminate\Support\Str::slug($state))
                            ),

                        TextInput::make('slug')
                            ->required(),

                    ])
                    ->columns(2),

                Section::make('Hero Section')
                    ->schema([

                        TextInput::make('hero_title'),

                        Textarea::make('hero_description'),

                        FileUpload::make('hero_image')
                            ->image()
                            ->disk('public')
                            ->directory('pages'),

                    ]),

                Section::make('SEO')
                    ->schema([

                        TextInput::make('seo_title'),

                        Textarea::make('meta_description'),

                    ]),

                Section::make('Page Content')
                    ->schema([

                        RichEditor::make('content')
                            ->columnSpanFull(),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
