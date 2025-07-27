<?php

namespace App\Filament\Resources\StudentResource\Widgets;

use App\Models\StudentActivityResult;
use Filament\Forms\Components\TextInput;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class StudentProgressChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'studentProgressChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = '';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */

    public ?string $recordId = null;

    protected static bool $isLazy = true;

    public function getColumnSpan(): int | string | array
    {
        return 'full'; // or 6, 8, 'half', etc.
    }

    protected function getOptions(): array
    {
        // $barangay = $this->record[0];
        // $data = [50, 60, 70, 80, 90];
        // $labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
        // // If real student record, fetch from DB:
        if ($this->recordId) {
            $results = StudentActivityResult::where('student_id', $this->recordId)
                ->orderBy('created_at')
                ->get();

            $data = $results->pluck('accuracy')->toArray();
            $labels = $results->pluck('created_at')->map(fn($d) => $d->format('M d'))->toArray();
        }

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Accuracy (%)',
                    'data' => $data,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
            ],
            'yaxis' => [
                'max' => 100,   
                'min' => 0,
                'tickAmount' => 5,
            ],
            'colors' => ['#112d4e'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
