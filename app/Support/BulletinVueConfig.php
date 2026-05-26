<?php

namespace App\Support;

use Illuminate\Http\Request;

class BulletinVueConfig
{
    public static function get(Request $request, array $options = []): array
    {
        $trashed = ! empty($options['trashed']);

        $userOptions = [
            ['value' => 'every_one', 'label' => 'Every One'],
            ['value' => 'specific_user', 'label' => 'Specific User'],
        ];

        $targetRoles = collect(BulletinAudience::targetRoleOptions())
            ->map(fn (string $label, string $value) => ['value' => $value, 'label' => $label])
            ->values()
            ->all();

        $sortOptions = collect(BulletinAudience::adminSortOptions())
            ->map(fn (string $label, string $value) => ['value' => $value, 'label' => $label])
            ->values()
            ->all();

        $audienceOptions = [
            ['value' => '', 'label' => 'All'],
            ['value' => 'every_one', 'label' => 'Every One'],
            ['value' => 'specific_user', 'label' => 'Specific User'],
        ];

        $perPageOptions = collect([10, 15, 25, 50, 100])
            ->map(fn (int $n) => ['value' => (string) $n, 'label' => (string) $n])
            ->all();

        $autoOpen = null;
        if ($request->boolean('create')) {
            $autoOpen = 'create';
        } elseif ($request->filled('edit')) {
            $autoOpen = ['edit' => (int) $request->input('edit')];
        } elseif ($request->filled('show')) {
            $autoOpen = ['show' => (int) $request->input('show')];
        }

        return [
            'type' => 'bulletins',
            'singular' => 'Bulletin',
            'addLabel' => 'Add New Bulletin',
            'trashed' => $trashed,
            'autoOpen' => $autoOpen,
            'defaultFilters' => [
                'search' => (string) $request->input('search', ''),
                'sort' => (string) $request->input('sort', 'newest'),
                'audience' => (string) $request->input('audience', ''),
                'per_page' => (string) TenantListPaginator::perPage($request),
            ],
            'filterOptions' => [
                'sort' => $sortOptions,
                'audience' => $audienceOptions,
                'per_page' => $perPageOptions,
            ],
            'columns' => [
                ['key' => 'id', 'label' => '#'],
                ['key' => 'attachment_url', 'label' => 'File', 'type' => 'attachment'],
                ['key' => 'bulletin_title', 'label' => 'Title'],
                ['key' => 'description_short', 'label' => 'Description'],
                ['key' => 'user_option_label', 'label' => 'Audience', 'type' => 'badge', 'badgeKey' => 'user_option_badge'],
                ['key' => 'target_role_label', 'label' => 'User type'],
                ['key' => 'posted_at', 'label' => 'Posted'],
            ],
            'showFields' => [
                ['key' => 'bulletin_title', 'label' => 'Title'],
                ['key' => 'bulletin_description', 'label' => 'Description'],
                ['key' => 'user_option_label', 'label' => 'Audience'],
                ['key' => 'target_role_label', 'label' => 'User type'],
                ['key' => 'attachment_url', 'label' => 'Attachment', 'type' => 'link'],
                ['key' => 'posted_at', 'label' => 'Posted'],
            ],
            'fields' => [
                [
                    'name' => 'user_option',
                    'label' => 'Audience',
                    'type' => 'select',
                    'options' => $userOptions,
                    'required' => true,
                ],
                [
                    'name' => 'target_role',
                    'label' => 'User type',
                    'type' => 'select',
                    'options' => $targetRoles,
                    'required' => true,
                    'showWhen' => ['field' => 'user_option', 'value' => 'specific_user'],
                ],
                [
                    'name' => 'bulletin_title',
                    'label' => 'Title',
                    'type' => 'text',
                    'required' => true,
                ],
                [
                    'name' => 'bulletin_description',
                    'label' => 'Description',
                    'type' => 'textarea',
                    'required' => true,
                    'full' => true,
                ],
                [
                    'name' => 'image',
                    'label' => 'Attachment',
                    'type' => 'media',
                    'mediaType' => 'image',
                    'accept' => '.jpg,.jpeg,.png,.gif,.webp,.pdf',
                    'full' => true,
                    'hint' => MediaUpload::hint(2048, false),
                    'urlPlaceholder' => 'https://example.com/file.pdf',
                ],
            ],
            'api' => [
                'index' => route('tenant_bulletins_api_index', $trashed ? ['trashed' => 1] : []),
                'store' => route('tenant_bulletins_api_store'),
                'show' => route('tenant_bulletins_api_show', ['id' => '__ID__']),
                'update' => route('tenant_bulletins_api_update', ['id' => '__ID__']),
                'destroy' => $trashed ? null : route('tenant_bulletins_api_destroy', ['id' => '__ID__']),
                'restore' => $trashed ? route('tenant_bulletins_api_restore', ['id' => '__ID__']) : null,
            ],
            'links' => [
                'list' => route('tenant_bulletin_index'),
                'create' => route('tenant_bulletin_create'),
                'trashed' => route('tenant_deleted_bulletin_list'),
                'export' => route('bulletin_export'),
            ],
            'csrf' => csrf_token(),
        ];
    }
}
