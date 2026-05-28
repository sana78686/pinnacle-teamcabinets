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

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId,
            'catalog_visibility' => 'nullable|array',
            'door_factors' => 'nullable|array',
            'gross_sale' => 'nullable|numeric|min:0',
        ];

        if ($this->adminMayChangeTargetRole()) {
            $rules['role_id'] = 'required';
        }

        return $rules;
    }

    protected function adminMayChangeTargetRole(): bool
    {
        $actor = $this->user();
        if (! $actor || ! method_exists($actor, 'isAdmin') || ! $actor->isAdmin()) {
            return false;
        }

        $targetId = (int) $this->route('id');

        return $targetId > 0 && $targetId !== (int) $actor->id;
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
