<?php

namespace App\Filament\Auth;

use App\Models\User;
use App\Models\Student;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;

class CustomRegistration extends Register {

    public function getExtraBodyAttributes(): array
    {
        return [
            'class' => 'register-page',
        ];
    }

    protected ?string $maxWidth = 'xl';

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            )
        ];
    }

    protected function handleRegistration(array $data): Model
    {
        $user = User::create($data);

        $user->assignRole('Student');

        Student::create([
            'user_id' => $user->id,
        ]);

        return $user;

    }

}