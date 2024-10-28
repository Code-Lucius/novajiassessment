<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
            'lastName' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{11}$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^[\w\.-]+@(gmail\.com|yahoo\.com|outlook\.com)$/i'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ],
            'dob' => [
                'required',
                'date',
                'before:'.now()->subYears(18)->toDateString(),
            ],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'lastName' => $input['lastName'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'dob' => $input['dob'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
