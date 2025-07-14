<?php

namespace App\Filament\Student\Resources\StudentActivityResultResource\Pages;

use App\Filament\Student\Resources\StudentActivityResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentActivityResult extends EditRecord
{
    protected static string $resource = StudentActivityResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
