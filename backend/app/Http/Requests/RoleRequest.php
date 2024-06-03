<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('roles')->where(
                    function ($query) {
                        return $query->where('company_id', $this->company_id);
                    }
                ),
                'max:40','min:3'
            ],
            'description' => ['nullable', 'min:3','max:100'],
        ];
    }
}
