<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('positions')->where(
                    function ($query) {
                        return $query->where('company_id', $this->company_id);
                    }
                ),
                'min:3','max:50'
            ]
        ];
    }
}
