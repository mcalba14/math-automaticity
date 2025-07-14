<?php

namespace App\Filament\Student\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\StudentActivityResult;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Student\Resources\StudentActivityResultResource\Pages;
use App\Filament\Student\Resources\StudentActivityResultResource\RelationManagers;

class StudentActivityResultResource extends Resource
{
    protected static ?string $model = StudentActivityResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Activity Results';

    public static function getBreadcrumb(): string { return 'Activity Results'; }


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
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('student', function (Builder $query) {
                    $query->where('user_id', auth()->id());
                });
            })
            ->columns([
                Tables\Columns\TextColumn::make('studentActivityAttempt.lesson.title')
                    ->formatStateUsing(function ($state) {
                        $title = explode(',', $state);

                        return $title[0];
                    })
                    ->label('Lesson Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('accuracy')
                    ->suffix('%')
                    ->label('Accuracy'),
                Tables\Columns\TextColumn::make('score')
                    // ->formatStateUsing(function (Model $record) {
                    //     return $record->score >= 70 ? 'Passed' : 'Failed';
                    // })
                    ->formatStateUsing(fn(Model $record) => $record->score >= 70 ? 'Passed' : 'Failed')
                    ->badge()
                    ->color(fn (Model $record) => $record->score >= 70 ? 'success' : 'danger')
                    ->label('Status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Date Taken'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListStudentActivityResults::route('/'),
            // 'create' => Pages\CreateStudentActivityResult::route('/create'),
            // 'edit' => Pages\EditStudentActivityResult::route('/{record}/edit'),
        ];
    }
}
