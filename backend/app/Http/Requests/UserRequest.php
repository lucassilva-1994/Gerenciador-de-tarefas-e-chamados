<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required','unique:users,employee_id'],
            'company_id' => ['required'],
            'password' => ['required','min:3','max:60']
        ];
    }
}
