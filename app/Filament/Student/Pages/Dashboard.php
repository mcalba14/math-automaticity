<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static string $view = 'filament.student.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Student\Widgets\StatsOverview::class,
        ];

    }
}
