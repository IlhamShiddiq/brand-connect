<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];

        switch ($this->method()) {
            case 'POST':
                $rules = $this->getCreateRules();
                break;
            case 'PUT':
                $rules = $this->getUpdateRules();
                break;
        }

        return $rules;
    }

    /**
     * Get the validation rules for creating a new resource.
     *
     * @return array
     */
    private function getCreateRules(): array
    {
        return [
            'name' => [
                'required', 'string'
            ],
            'description' => [
                'required', 'string'
            ]
        ];
    }

    /**
     * Get the validation rules for updating a resource.
     *
     * @return array
     */
    private function getUpdateRules(): array
    {
        return [
            'name' => [
                'required', 'string'
            ],
            'description' => [
                'required', 'string'
            ]
        ];
    }
}
