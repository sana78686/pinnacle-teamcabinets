<?php

namespace App\Http\Requests;

use App\Services\UserDoorFactorService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_id' => 'required',
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'country_id' => 'required',
            'state_id' => 'required',
            'password' => 'nullable|string|min:8',
            'point_factor' => 'nullable|numeric|min:0|max:1',
            'catalog_visibility' => 'nullable|array',
            'door_factors' => 'nullable|array',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $v) {
            $doorErrors = app(UserDoorFactorService::class)->doorFactorValidationErrors($this);
            if ($doorErrors) {
                foreach ($doorErrors as $field => $messages) {
                    foreach ((array) $messages as $message) {
                        $v->errors()->add($field, $message);
                    }
                }
            }
        });
    }

    protected function failedValidation(Validator $validator): void
    {
        if ($this->ajax() || $this->wantsJson()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422));
        }

        parent::failedValidation($validator);
    }
}
