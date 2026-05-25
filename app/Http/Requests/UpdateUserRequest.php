<?php

namespace App\Http\Requests;

use App\Services\UserDoorFactorService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId,
            'role_id' => 'required',
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
                'message' => 'Please fix the errors below.',
                'errors' => $validator->errors(),
            ], 422));
        }

        parent::failedValidation($validator);
    }
}
