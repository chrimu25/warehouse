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
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'size:10', 'unique:users'],
            'nid' => ['required', 'string', 'size:16', 'unique:users'],
            'province' => ['nullable', 'string', 'max:55'],
            'district' => ['nullable', 'string', 'max:55'],
            'sector' => ['nullable', 'string', 'max:55'],
            'sector' => ['nullable', 'string', 'max:55'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone'=>$input['phone'],
            'role'=>'Client',
            'nid'=>$input['nid'],
            // 'province'=>$input['province'],
            // 'district'=>$input['district'],
            // 'sector'=>$input['sector'],
            // 'cell'=>$input['cell'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
