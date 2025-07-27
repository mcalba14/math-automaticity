<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Models\Student;
use Filament\Resources\Pages\Page;
use App\Models\StudentActivityResult;
use App\Filament\Resources\StudentResource;
use App\Filament\Resources\StudentResource\Widgets\StudentProgressChart;

class StudentProgress extends Page
{
    protected static string $resource = StudentResource::class;

    public ?string $recordId;

    public function mount(string $record): void
    {
        $this->recordId = $record;
    }

    public function getHeaderWidgets(): array
    {
        return [
            StudentProgressChart::make(['recordId' => $this->recordId]),
        ];
    }
    protected static string $view = 'filament.resources.student-resource.pages.student-progress';
}
