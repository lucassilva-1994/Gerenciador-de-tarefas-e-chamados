<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'legal_name' => ['required','max:100','min:10'],
            'trade_name' => ['required','max:100','min:10'],
            'cnpj' => ['required','max:100','min:10', Rule::unique('companies','cnpj')->ignore($this->id)]
        ];
    }
}
