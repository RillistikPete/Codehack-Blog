<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

/**
 * Public self-registration | Foritfy
 **/
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            // if you want on registration
            // 'role_id' => ['nullable', 'integer'],
            // 'photo_id' => ['nullable', 'integer'],
            // 'is_active' => ['nullable', 'boolean'],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            // if you put $input['role_id'] then someone can inject json attack to create admin user
            'role_id' => 2, // default to regular user 
            'photo_id' => null, // these will always be null
            'is_active' => 1, // always 1 unless added to registration
        ]);
    }
}
