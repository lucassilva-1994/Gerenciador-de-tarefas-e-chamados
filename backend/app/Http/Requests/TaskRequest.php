<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','min:3','max:40'],
            'description' => ['required','min:3','max:100'],
            'is_done' => ['required'],
            'owner_id' => Rule::requiredIf(auth()->user()->visibility == 'Administrador' || auth()->user()->visibility == 'Gerente')
        ];
    }
}
