<?php

namespace App\Filament\Student\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Lesson;
use App\Models\Activity;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentActivityResult;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Student\Resources\LessonResource\Pages;
use App\Filament\Student\Resources\LessonResource\RelationManagers;
use App\Filament\Student\Resources\ActivityResource\Pages\EditActivity;
use App\Filament\Student\Resources\ActivityResource\Pages\ListActivities;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(false) //Disable clickable rows
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('activities');
            })
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('difficultyLevel.name')
                    ->label('Difficulty Level'),
                TextColumn::make('items_count')
                    ->default(function(Model $record){
                        // dd($record);
                        return Activity::where('lesson_id', $record['id'])->where('difficulty_level_id', $record['difficulty_level_id'])
                            ->get()
                            ->count();
                    })
                    ->badge()
                    ->color('success')
                    ->label('Item(s)'),
                TextColumn::make('description'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Start Activity')
                ->label(fn(Lesson $record) =>
                    StudentActivityResult::where('student_id', Auth::user()->student->id ?? null)
                        ->where('lesson_id', $record->id)
                        ->exists()
                        ? 'Retake'
                        : 'Start Activity'
                )
                ->icon(fn(Lesson $record) =>
                    StudentActivityResult::where('student_id', Auth::user()->student->id ?? null)
                        ->where('lesson_id', $record->id)
                        ->exists()
                        ? 'heroicon-o-arrow-path'
                        : 'heroicon-o-rocket-launch')
                ->button()
                ->color('info')
                ->url(
                    fn (Lesson $record): string => static::getUrl('start-activity', [
                        'record' => $record->id,
                    ])
                ),
            ])
            ->actionsColumnLabel('Actions')
            ->striped(false)
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),

            // 'activities.index' => ListActivities::route('/{parent}/details'),
            'start-activity' => Pages\StartActivity::route('/{record}'),
        ];
    }
}
