<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','min:3','max:100'],
            'email' => [
                'required',
                Rule::unique('employees')->where(
                    function ($query) {
                        return $query->where('company_id', $this->company_id);
                    }
                ),
                'min:3', 'max:100'
            ]
        ];
    }
}
