<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Lesson;
use Filament\Forms\Get;
use App\Models\Activity;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DifficultyLevel;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\ActivityResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ActivityResource\RelationManagers;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ToggleButtons::make('difficulty_level_id')
                    ->label('Difficulty Level')
                    ->live()
                    ->default(1)
                    ->options(DifficultyLevel::query()->get()->pluck('name', 'id'))
                    ->inline()->grouped()->required(),

                Select::make('lesson_id')
                    ->label('Lesson')
                    ->options(function(Get $get){
                        return Lesson::query()
                            ->where('difficulty_level_id', $get('difficulty_level_id'))
                            ->pluck('title', 'id')
                            ->toArray();
                    })
                    ->native(false)
                    ->preload()
                    ->searchable()
                    ->required(),

                Textarea::make('question_text')
                    ->columnSpan('full')
                    ->label('Question')
                    ->required(),

                TextInput::make('answer')
                    ->required(),

                Select::make('type')
                    ->options([
                        'multiple_choice' => 'Multiple Choice',
                        'short_answer' => 'Short Answer',
                        'true_false' => 'True/False',
                    ])
                    ->default('short_answer')
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lesson.title')->label('Lesson'),
                TextColumn::make('difficultyLevel.name')->label('Difficulty'),
                TextColumn::make('type')->label('Type'),
                TextColumn::make('question_text')->label('Question')->limit(50),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListActivities::route('/'),
            // 'create' => Pages\CreateActivity::route('/create'),
            // 'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
