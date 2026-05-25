<?php

namespace App\Support;

use App\Services\TenantRoleService;

class AdminUploadVueConfig
{
    public static function get(): array
    {
        $userTypes = array_merge(
            [['value' => '', 'label' => 'All users']],
            collect(TenantRoleService::DEFAULT_ROLES)
                ->map(fn (string $role) => ['value' => $role, 'label' => ucfirst(str_replace('-', ' ', $role))])
                ->values()
                ->all()
        );

        return [
            'type' => 'admin-uploads',
            'singular' => 'Upload',
            'addLabel' => 'Upload File',
            'columns' => [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'file_name', 'label' => 'File'],
                ['key' => 'user_type_label', 'label' => 'Visible to'],
                ['key' => 'description', 'label' => 'Description'],
                ['key' => 'uploaded_by', 'label' => 'Uploaded by'],
                ['key' => 'created_at', 'label' => 'Date'],
            ],
            'showFields' => [
                ['key' => 'file_name', 'label' => 'File'],
                ['key' => 'user_type_label', 'label' => 'Visible to'],
                ['key' => 'description', 'label' => 'Description'],
                ['key' => 'file_url', 'label' => 'Download', 'type' => 'link'],
            ],
            'fields' => [
                [
                    'name' => 'user_type',
                    'label' => 'User type (visibility)',
                    'type' => 'select',
                    'options' => $userTypes,
                    'full' => true,
                ],
                [
                    'name' => 'file',
                    'label' => 'File',
                    'type' => 'file',
                    'required' => true,
                    'full' => true,
                ],
                [
                    'name' => 'description',
                    'label' => 'Description',
                    'type' => 'textarea',
                    'full' => true,
                    'rows' => 3,
                ],
            ],
            'api' => [
                'index' => route('tenant_admin_uploads_api_index'),
                'store' => route('tenant_admin_uploads_api_store'),
                'destroy' => route('tenant_admin_uploads_api_destroy', ['id' => '__ID__']),
            ],
            'csrf' => csrf_token(),
            'allowEdit' => false,
            'allowShow' => true,
        ];
    }
}
