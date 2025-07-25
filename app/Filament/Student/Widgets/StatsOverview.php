<?php

namespace App\Filament\Student\Widgets;

use App\Models\StudentActivityResult;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // dd(auth()->id());
        return [
            Stat::make('Total Activities', StudentActivityResult::whereRelation('student', 'user_id', auth()->id())->count())
            ->color('info')
            ->chart(StudentActivityResult::whereRelation('student', 'user_id', auth()->id())->pluck('accuracy')->toArray())
            ->url(route('filament.student.resources.student-activity-results.index')),

            Stat::make('Highest Activity Score', StudentActivityResult::whereRelation('student', 'user_id', auth()->id())->max('accuracy'))
            ->chart(StudentActivityResult::whereRelation('student', 'user_id', auth()->id())->pluck('accuracy')->toArray())
            ->description('')
            ->color('info'),

            Stat::make('Lowest Activity Score', StudentActivityResult::whereRelation('student', 'user_id', auth()->id())->min('accuracy'))
            ->chart(StudentActivityResult::whereRelation('student', 'user_id', auth()->id())->pluck('accuracy')->toArray())
            ->color('info'),

            Stat::make('Average Activity Score', \number_format(StudentActivityResult::whereRelation('student', 'user_id', auth()->id())->avg('accuracy'),2))
            ->chart(StudentActivityResult::whereRelation('student', 'user_id', auth()->id())->pluck('accuracy')->toArray())
            ->color('info'),
        ];
    }
}
