<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserBalance;
use App\Models\Profile;
use App\Models\Bot\UserBot;
use App\Models\Bot\Notice;
use App\Models\Partner\ClassicPartner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Contracts\CreatesNewUsers;

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
        $validate = Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'username' => $input['email'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            
        ]);


        $profile = new Profile();
        $user->profile()->save($profile);
        
        return $user;
    }
}
