<?php

namespace App\Filament\Student\Resources\LessonResource\Pages;

use Filament\Forms;
use App\Models\Activity;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentActivityResult;
use App\Models\StudentActivityAttempt;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Student\Resources\LessonResource;

class StartActivity extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = LessonResource::class;
    protected ?string $heading = '';
    protected static string $view = 'filament.student.resources.lesson-resource.pages.start-activity';

    public array $questions = [];
    public array $answeredQuestions = [];
    public ?array $data = [];
    public bool $sessionFinished = false;

    public int $timeLeft = 0;
    public ?int $currentLimit = null;
    public int $step = 0;   
    public int $totalQuestions;
    public array $attempts = [];
    public array $questionsTaken = [];
    public array $attemptResults = [];
    public int $totalCorrect = 0;
    public $attemptId;

    public function mount($record): void
    {
        $this->attempts = [];
        $this->attemptResults = [];
        $this->questionsTaken = [];
        $this->answeredQuestions = [];
        $this->data = ['answer' => ''];
        $this->loadQuestion($record);
        $this->attemptId = str()->random();
    }

    public function tick(): void
    {
        if ($this->sessionFinished) return;

        if ($this->timeLeft > 0) {
            $this->timeLeft--;
        } else {
            $this->submit(); // auto-submit on timeout
        }
    }

    // Convert MM:SS format to seconds
    function mmssToSeconds(string $mmss): int
    {
        [$minutes, $seconds] = explode(':', $mmss);
        return ((int)$minutes * 60) + (int)$seconds;
    }

    public function loadQuestion($record = null): void
    {
        $this->step++;
        $query = Activity::query()->with('difficultyLevel');
        if ($record) {
            $query->where('lesson_id', $record);
            $this->totalQuestions = $query->where('lesson_id', $record)->count();
        }
        if (!empty($this->answeredQuestions)) {
            $query->whereNotIn('id', $this->answeredQuestions);
        }
        $question = $query->inRandomOrder()->first();

        if ($question) {
            $this->questions = $question->toArray();
            $this->answeredQuestions[] = $this->questions['id'];
            $this->data['answer'] = ''; // Reset answer for new question

            $this->currentLimit = $this->mmssToSeconds($question->difficultyLevel->time_limit) ?? 30;
            $this->timeLeft = $this->currentLimit;
        } else {
            $this->sessionFinished = true;
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('answer')
                    ->label('Your Answer')
                    ->autofocus(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        if (!$this->sessionFinished) {
            $this->attempts[] = [
                'attempt_id' => $this->attemptId,
                'student_id' => Auth::user()->student->id,
                'lesson_id' => $this->questions['lesson_id'],
                'activity_id' => $this->questions['id'],
                'student_answer' => $data['answer'] ?? 'null',
                'is_correct' => $data['answer'] === $this->questions['answer'],
                // 'time_taken' => $this->currentLimit - $this->timeLeft,
            ];

            $this->questionsTaken[] = $this->questions['id'];

            if ($data['answer'] === $this->questions['answer']) {
                $this->totalCorrect++;
            }

        }
        if($this->step >= $this->totalQuestions) {
            Notification::make()
                ->title('Session Complete')
                ->body('You have answered all questions!')
                ->success()
                ->send();
            $this->sessionFinished = true;

            $percentage = $this->totalQuestions > 0
            ? round(($this->totalCorrect / $this->totalQuestions) * 100, 2) : 0;

            foreach ($this->attempts as $attempt) {
                StudentActivityAttempt::create($attempt);
            }

            StudentActivityResult::create([
                'attempt_id' => $this->attemptId,
                'questions_taken' => json_encode($this->questionsTaken), // <-- convert to string
                'total_correct' => $this->totalCorrect,
                'score' => $percentage,
            ]);

            // return;
        }

        $this->loadQuestion();
    }
}