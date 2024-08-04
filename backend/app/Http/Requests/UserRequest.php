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
                'name' => ['required','min:3','max:100'],
                'username' => ['required','min:3','max:100','unique:users,username'],
                'email' => ['required','max:100','email','email:dns','unique:users,email'],
                'password' => ['required','min:8','confirmed'],
                'visibility' => [
                    'required',
                    Rule::in(['Administrador', 'Gerente', 'Operacional']),
                    function ($attribute, $value, $fail) {
                        if (auth()->user()->visibility === 'Gerente' && $value === 'Administrador') {
                            $fail('Você não tem permissão para cadastrar Administradores.');
                        }
                    }
                ],
                'department_id' => Rule::requiredIf(auth()->user()->visibility == 'Administrador')
            ];
        } elseif($this->path() === 'api/users/update/'.$this->id){
            return [
                'name' => ['required','min:3','max:100'],
                'username' => ['required','min:3','max:100', Rule::unique('users')->ignore($this->id)],
                'email' => ['required','max:100','email','email:dns',Rule::unique('users')->ignore($this->id)],
                'visibility' => [
                    'required',
                    Rule::in(['Administrador', 'Gerente', 'Operacional']),
                    function ($attribute, $value, $fail) {
                        if (auth()->user()->visibility === 'Gerente' && $value === 'Administrador') {
                            $fail('Você não tem permissão para cadastrar/alterar Administradores.');
                        }
                    }
                ],
                'department_id' => Rule::requiredIf(auth()->user()->visibility == 'Administrador')
            ];
        }
        
        elseif($this->path() === 'api/users/change-password'){
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
