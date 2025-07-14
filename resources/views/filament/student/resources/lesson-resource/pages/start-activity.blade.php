<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="description">
            <div class="flex items-center justify-between mb-4">
            @if (!$this->sessionFinished)
                <div class="mb-2">
                    <strong>⏳ Time left for this question:</strong>
                    <span wire:poll.1000ms="tick">{{ $this->timeLeft }} seconds</span>
                </div>
            @endif
            @if ($this->sessionFinished)
                <div class="mb-2 bg-gray-200 text-gray-800 px-2 py-1 rounded-lg">
                    <strong>Session Completed!</strong>
                </div>
            @else
                <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded-lg">
                    <strong>Progress:</strong> {{ $this->step }} /{{ $this->totalQuestions }}
                </span>
            @endif
        </div>
        </x-slot>
        @if (!$this->sessionFinished)
            <div class="mb-4">
                <strong>Question:</strong><br>
                {{ $this->questions['question_text'] ?? 'Loading...' }}
            </div>
            <form wire:submit.prevent="submit">
                {{ $this->form }}
                <x-filament::button class="mt-3" icon="heroicon-o-paper-airplane" type="submit">
                    Submit Answer
                </x-filament::button>
            </form>
        @else
            <div class="text-center py-10">
                <h2 class="text-2xl font-bold mb-2">🎉 Session Complete!</h2>
                <p class="text-lg">You have answered all questions. Well done!</p>
            </div>
        @endif
        

    </x-filament::section>
</x-filament-panels::page>
