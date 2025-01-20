<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutletRequest extends FormRequest
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
            'brand_id' => [
                'required', 'uuid', 'exists:brands,id'
            ],
            'name' => [
                'required', 'string'
            ],
            'phone_number' => [
                'required', 'string', 'min:5', 'max:15'
            ],
            'description' => [
                'required', 'string'
            ],
            'address' => [
                'required', 'string'
            ],
            'latitude' => [
                'nullable'
            ],
            'longitude' => [
                'nullable'
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
            'brand_id' => [
                'required', 'uuid', 'exists:brands,id'
            ],
            'name' => [
                'required', 'string'
            ],
            'phone_number' => [
                'required', 'string', 'min:5', 'max:15'
            ],
            'description' => [
                'required', 'string'
            ],
            'address' => [
                'required', 'string'
            ],
            'latitude' => [
                'nullable'
            ],
            'longitude' => [
                'nullable'
            ]
        ];
    }
}
