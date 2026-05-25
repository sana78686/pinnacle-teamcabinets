<?php

namespace App\Support;

use App\Services\TenantRoleService;

class ManageDocumentVueConfig
{
    /**
     * @param  array{trashed?: bool}  $options
     */
    public static function get(array $options = []): array
    {
        $trashed = ! empty($options['trashed']);

        $userTypes = array_merge(
            [['value' => 'all', 'label' => 'All users']],
            collect(TenantRoleService::DEFAULT_ROLES)
                ->map(fn (string $role) => ['value' => $role, 'label' => ucfirst(str_replace('-', ' ', $role))])
                ->values()
                ->all()
        );

        $statusOptions = [
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

        return [
            'type' => 'manage-documents',
            'singular' => 'Document',
            'addLabel' => 'Add Document',
            'trashed' => $trashed,
            'columns' => [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'user_type', 'label' => 'User type'],
                ['key' => 'document_name', 'label' => 'File name'],
                ['key' => 'status', 'label' => 'Status'],
                ['key' => 'created_at', 'label' => 'Date'],
            ],
            'showFields' => [
                ['key' => 'user_type', 'label' => 'User type'],
                ['key' => 'document_name', 'label' => 'File'],
                ['key' => 'status', 'label' => 'Status'],
                ['key' => 'file_url', 'label' => 'Download', 'type' => 'link'],
            ],
            'fields' => [
                [
                    'name' => 'user_type',
                    'label' => 'User type',
                    'type' => 'select',
                    'options' => $userTypes,
                    'required' => true,
                ],
                [
                    'name' => 'status',
                    'label' => 'Status',
                    'type' => 'select',
                    'options' => $statusOptions,
                ],
                [
                    'name' => 'file',
                    'label' => 'Document file',
                    'type' => 'file',
                    'accept' => '.pdf,.doc,.docx,.zip',
                    'full' => true,
                    'tip' => 'PDF, DOC, DOCX, or ZIP.',
                ],
            ],
            'api' => [
                'index' => route('tenant_manage_documents_api_index', $trashed ? ['trashed' => 1] : []),
                'store' => route('tenant_manage_documents_api_store'),
                'show' => route('tenant_manage_documents_api_show', ['id' => '__ID__']),
                'update' => route('tenant_manage_documents_api_update', ['id' => '__ID__']),
                'destroy' => $trashed ? null : route('tenant_manage_documents_api_destroy', ['id' => '__ID__']),
                'restore' => $trashed ? route('tenant_manage_documents_api_restore', ['id' => '__ID__']) : null,
            ],
            'links' => [
                'list' => route('tenant_setting_manage_documentation_list'),
                'create' => route('tenant_setting_manage_document'),
                'trashed' => route('tenant_deleted_manage_document_list'),
            ],
            'csrf' => csrf_token(),
        ];
    }
}
