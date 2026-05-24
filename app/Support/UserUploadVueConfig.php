<?php

namespace App\Support;

class UserUploadVueConfig
{
    public static function get(): array
    {
        return [
            'type' => 'user-uploads',
            'singular' => 'Upload',
            'addLabel' => 'Add Upload',
            'columns' => [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'file_name', 'label' => 'File name'],
                ['key' => 'description', 'label' => 'Description'],
                ['key' => 'created_at', 'label' => 'Date'],
            ],
            'showFields' => [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'file_name', 'label' => 'File name'],
                ['key' => 'description', 'label' => 'Description'],
                ['key' => 'file_url', 'label' => 'File', 'type' => 'link'],
                ['key' => 'created_at', 'label' => 'Uploaded'],
            ],
            'fields' => [
                [
                    'name' => 'file',
                    'label' => 'File',
                    'type' => 'file',
                    'accept' => '.jpg,.jpeg,.png,.doc,.docx,.pdf',
                    'full' => true,
                    'tip' => 'Allowed: JPG, JPEG, PNG, DOC, DOCX, PDF.',
                ],
                [
                    'name' => 'description',
                    'label' => 'Description',
                    'type' => 'textarea',
                    'required' => true,
                    'full' => true,
                    'rows' => 4,
                    'placeholder' => 'Describe this file',
                ],
            ],
            'api' => [
                'index' => route('tenant_user_uploads_api_index'),
                'store' => route('tenant_user_uploads_api_store'),
                'show' => route('tenant_user_uploads_api_show', ['id' => '__ID__']),
                'update' => route('tenant_user_uploads_api_update', ['id' => '__ID__']),
                'destroy' => route('tenant_user_uploads_api_destroy', ['id' => '__ID__']),
            ],
            'csrf' => csrf_token(),
        ];
    }
}
