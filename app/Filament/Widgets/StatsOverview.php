<?php

namespace App\Filament\Widgets;

use App\Models\Lesson;
use App\Models\Student;
use App\Models\Activity;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Lessons Available', Lesson::count())
            ->chart([2,2,3])
            ->description('')
            ->color('info'),
            Stat::make('Questions Available', Activity::count())
            ->chart([2,2,3])
            ->description('')
            ->color('info'),
            Stat::make('Number of Students', Student::count())
            ->chart([2,2,3])
            ->description('')
            ->color('info'),
        ];
    }
}
