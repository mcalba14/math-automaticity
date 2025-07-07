<?php

namespace App\Filament\Resources\LessonResource\Pages;

use Filament\Actions;
use App\Models\DifficultyLevel;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LessonResource;

class ListLessons extends ListRecords
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->modalWidth('xl'),
        ];
    }

    public function getTabs(): array
    {
        $levels = DifficultyLevel::all();
        $tabs = $levels->mapWithKeys(function ($level) {
            return [
                $level->name => Tab::make()
                    ->label($level->name)
                    ->modifyQueryUsing(fn (Builder $query) => $query->where('difficulty_level_id', $level->id)),
            ];
        });

        return $tabs->toArray();
    }
}
