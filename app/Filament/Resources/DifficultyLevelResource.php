<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DifficultyLevel;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DifficultyLevelResource\Pages;
use App\Filament\Resources\DifficultyLevelResource\RelationManagers;

class DifficultyLevelResource extends Resource
{
    protected static ?string $model = DifficultyLevel::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                TextInput::make('time_limit')
                ->label('Time Limit')
                ->default('00:01')
                ->mask('99:99')
                ->placeholder('mm:ss')
                ->required()
                ->suffix('min:sec')
                ->rules([
                    fn (): Closure => function (string $attribute, $value, Closure $fail) {
                        if (preg_match('/^(\d{1,2}):(\d{2})$/', $value, $matches)) {
                            $minutes = (int)$matches[1];
                            $seconds = (int)$matches[2];
                            $totalSeconds = $minutes * 60 + $seconds;
                            if ($totalSeconds < 1) {
                                $fail('The time limit must be at least 1 second.');
                            }
                        } else {
                            $fail('The time limit format must be mm:ss.');
                        }
                    }
                ]),
                Textarea::make('description')
                    ->label('Description'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('time_limit'),
                TextColumn::make('description'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('xl'),
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
            'index' => Pages\ListDifficultyLevels::route('/'),
            // 'create' => Pages\CreateDifficultyLevel::route('/create'),
            // 'edit' => Pages\EditDifficultyLevel::route('/{record}/edit'),
        ];
    }
}
