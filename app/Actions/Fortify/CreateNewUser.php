<?php

namespace App\Actions\Fortify;

use App\Events\UserLoggedIn;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        // Split the full name into first name and last name
        $names = explode(' ', $input['name'], 2);
        $firstName = $names[0];
        $lastName = isset($names[1]) ? $names[1] : '';

        return tap(User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]), function ($user) {
        });
    }
}
