<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        if ($this->path() === 'api/users/forgot-password') {
            return [
                'email' => ['required', 'exists:users,email']
            ];
        } elseif ($this->path() === 'api/users/sign-in') {
            return [
                'login' => ['required', function ($attribute, $value, $fail) {
                    $exists = filter_var($value, FILTER_VALIDATE_EMAIL)
                        ? DB::table('users')->where('email', $value)->exists()
                        : DB::table('users')->where('username', $value)->exists();
                    if (!$exists) {
                        $fail('Email ou usuário não encontrado.');
                    }
                }],
                'password' => ['required']
            ];
        } elseif($this->path() === 'api/users/store'){
            return [
                'name' => ['required','min:3','max:100','regex:/^([A-Z][a-z]*)(\s[A-Z][a-z]*)*$/'],
                'username' => ['required','min:3','max:100','unique:users,username'],
                'email' => ['required','max:100','email','email:dns','unique:users,email'],
                'password' => ['required','min:8','confirmed'],
                'department_id' => Rule::requiredIf(auth()->user()->visibility == 1)
            ];
        } elseif($this->path() === 'api/users/change-password'){
            return [
                'password' => [
                    'required','min:8','confirmed',
                    function ($attribute, $value, $fail) {
                        $user = User::findOrFail($this->input('id'));
                        if (Hash::check($value, $user->password)) {
                            $fail('A nova senha não pode ser a mesma que a senha atual.');
                        }
                    },
                ]
            ];
        }
        return [];
    }
}
