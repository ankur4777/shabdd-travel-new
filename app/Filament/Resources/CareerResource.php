<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerResource\Pages;
use App\Models\Career;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CareerResource extends Resource
{
    protected static ?string $model = Career::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Careers';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Job Details')->schema([
                TextInput::make('title')->label('Main Title')->required(),
                Select::make('job_type')->options([
                    'Full Time' => 'Full Time',
                    'Part Time' => 'Part Time',
                    'Contract' => 'Contract',
                    'Internship' => 'Internship',
                    'Remote' => 'Remote',
                ])->searchable()->required(),
                TextInput::make('open_roles')->numeric()->minValue(1)->default(1)->required(),
                TextInput::make('experience')->placeholder('e.g. 1-3 Years')->required(),
                TextInput::make('job_location')->placeholder('e.g. Delhi, India')->required(),
                Toggle::make('is_active')->default(true)->label('Show on careers page'),
            ])->columns(2),

            Section::make('Job Roles & Responsibilities')->schema([
                Repeater::make('job_roles_responsibilities')
                    ->simple(TextInput::make('item')->required())
                    ->addActionLabel('Add responsibility')->reorderable()->columnSpanFull(),
            ]),
            Section::make('Required Skills')->schema([
                Repeater::make('required_skills')
                    ->simple(TextInput::make('item')->required())
                    ->addActionLabel('Add required skill')->reorderable()->columnSpanFull(),
            ]),
            Section::make('Good to Have')->schema([
                Repeater::make('good_to_have')
                    ->simple(TextInput::make('item')->required())
                    ->addActionLabel('Add item')->reorderable()->columnSpanFull(),
            ]),
            Section::make('What You Get')->schema([
                Repeater::make('what_you_get')
                    ->simple(TextInput::make('item')->required())
                    ->addActionLabel('Add benefit')->reorderable()->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->searchable()->sortable(),
            TextColumn::make('job_type')->badge(),
            TextColumn::make('open_roles')->label('Open Roles')->sortable(),
            TextColumn::make('experience'),
            TextColumn::make('job_location')->searchable(),
            IconColumn::make('is_active')->boolean(),
        ])->recordActions([EditAction::make()])
          ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCareers::route('/'),
            'create' => Pages\CreateCareer::route('/create'),
            'edit' => Pages\EditCareer::route('/{record}/edit'),
        ];
    }
}
