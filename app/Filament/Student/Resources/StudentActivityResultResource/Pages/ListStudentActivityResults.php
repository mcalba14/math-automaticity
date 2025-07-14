<?php

namespace App\Filament\Student\Resources\StudentActivityResultResource\Pages;

use App\Filament\Student\Resources\StudentActivityResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentActivityResults extends ListRecords
{
    protected static string $resource = StudentActivityResultResource::class;

    protected static ?string $title = 'Activity Results';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
