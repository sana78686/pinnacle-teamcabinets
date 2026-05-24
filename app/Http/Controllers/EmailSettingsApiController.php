<?php

namespace App\Http\Controllers;

use App\Models\ManageEmailsContent;
use App\Models\TenantSmtpSetting;
use App\Services\ManageEmailsContentService;
use App\Services\TenantSmtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EmailSettingsApiController extends Controller
{
    /** @var array<string, class-string> */
    protected array $types = [
        'smtp' => TenantSmtpSetting::class,
        'email-content' => ManageEmailsContent::class,
    ];

    public function meta(ManageEmailsContentService $templates): JsonResponse
    {
        $templates->ensureDefaults();

        $smtpAccounts = TenantSmtpSetting::query()
            ->orderBy('id')
            ->get(['id', 'from_email', 'smtp_host'])
            ->map(fn (TenantSmtpSetting $row) => [
                'value' => (string) $row->id,
                'label' => trim($row->from_email.' ('.$row->smtp_host.')'),
            ])
            ->values();

        return response()->json([
            'smtp_accounts' => $smtpAccounts,
        ]);
    }

    public function index(Request $request, string $type): JsonResponse
    {
        $this->assertType($type);
        $modelClass = $this->types[$type];
        $trashed = $request->boolean('trashed');

        $query = $trashed
            ? $modelClass::onlyTrashed()->latest('id')
            : $modelClass::query()->latest('id');

        if ($type === 'smtp') {
            $query->where('tenant_id', tenant('id'));
        }

        $paginator = $query->paginate(tenant_list_per_page())->withQueryString();

        return response()->json([
            'data' => collect($paginator->items())->map(fn ($row) => $this->serialize($type, $row)),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
        ]);
    }

    public function show(string $type, int $id): JsonResponse
    {
        $this->assertType($type);
        $record = $this->findRecord($type, $id, true);

        return response()->json(['data' => $this->serialize($type, $record, true)]);
    }

    public function store(Request $request, string $type): JsonResponse
    {
        $this->assertType($type);
        $record = $type === 'smtp'
            ? $this->storeSmtp($request)
            : $this->storeEmailContent($request);

        return response()->json([
            'message' => ($type === 'smtp' ? 'SMTP account' : 'Email template').' saved successfully.',
            'data' => $this->serialize($type, $record, true),
        ], 201);
    }

    public function update(Request $request, string $type, int $id): JsonResponse
    {
        $this->assertType($type);
        $record = $type === 'smtp'
            ? $this->updateSmtp($request, $id)
            : $this->updateEmailContent($request, $id);

        return response()->json([
            'message' => ($type === 'smtp' ? 'SMTP account' : 'Email template').' updated successfully.',
            'data' => $this->serialize($type, $record, true),
        ]);
    }

    public function destroy(string $type, int $id): JsonResponse
    {
        $this->assertType($type);
        $record = $this->findRecord($type, $id);

        if ($type === 'smtp' && $this->smtpInUse($record->id)) {
            throw ValidationException::withMessages([
                'smtp' => ['You cannot delete an SMTP account that is assigned to an email template.'],
            ]);
        }

        $record->delete();

        return response()->json(['message' => 'Deleted successfully.']);
    }

    public function restore(string $type, int $id): JsonResponse
    {
        $this->assertType($type);
        $modelClass = $this->types[$type];
        $record = $modelClass::onlyTrashed()->findOrFail($id);
        $record->restore();

        return response()->json([
            'message' => 'Restored successfully.',
            'data' => $this->serialize($type, $record, true),
        ]);
    }

    public function testSmtp(Request $request, TenantSmtpService $smtpService): JsonResponse
    {
        $rules = [
            'smtp_host' => 'required|string|max:255',
            'smtp_username' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
            'smtp_port' => 'required|integer|min:1|max:65535',
            'smtp_encryption' => 'required|string|in:tls,ssl,none',
            'test_recipient' => 'nullable|email|max:255',
        ];

        $existing = null;
        if ($request->filled('id')) {
            $existing = TenantSmtpSetting::query()->find($request->integer('id'));
        }

        if (! $existing || $request->filled('smtp_password')) {
            $rules['smtp_password'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        if (empty($validated['smtp_password']) && $existing) {
            $validated['smtp_password'] = $existing->smtp_password;
        }

        $validated['from_name'] = $request->input('from_name', tenant('company_name') ?? tenant('name'));
        $validated['test_recipient'] = $validated['test_recipient'] ?? $validated['from_email'];

        return response()->json($smtpService->testConnection($validated, true));
    }

    protected function storeSmtp(Request $request): TenantSmtpSetting
    {
        $validated = $request->validate([
            'smtp_host' => 'required|string|max:255',
            'smtp_username' => 'required|string|max:255',
            'smtp_password' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
            'from_name' => 'nullable|string|max:255',
            'smtp_port' => 'required|integer|min:1|max:65535',
            'smtp_encryption' => 'required|string|in:tls,ssl,none',
        ]);

        return TenantSmtpSetting::query()->create([
            'tenant_id' => tenant('id'),
            'smtp_host' => $validated['smtp_host'],
            'smtp_port' => $validated['smtp_port'],
            'smtp_encryption' => $validated['smtp_encryption'],
            'smtp_username' => $validated['smtp_username'],
            'smtp_password' => $validated['smtp_password'],
            'from_email' => $validated['from_email'],
            'from_name' => $validated['from_name'] ?? tenant('company_name') ?? tenant('name'),
        ]);
    }

    protected function updateSmtp(Request $request, int $id): TenantSmtpSetting
    {
        $record = TenantSmtpSetting::query()->findOrFail($id);

        $rules = [
            'smtp_host' => 'required|string|max:255',
            'smtp_username' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
            'from_name' => 'nullable|string|max:255',
            'smtp_port' => 'required|integer|min:1|max:65535',
            'smtp_encryption' => 'required|string|in:tls,ssl,none',
            'smtp_password' => 'nullable|string|max:255',
        ];

        $validated = $request->validate($rules);

        $record->fill([
            'smtp_host' => $validated['smtp_host'],
            'smtp_port' => $validated['smtp_port'],
            'smtp_encryption' => $validated['smtp_encryption'],
            'smtp_username' => $validated['smtp_username'],
            'from_email' => $validated['from_email'],
            'from_name' => $validated['from_name'] ?? $record->from_name,
        ]);

        if (! empty($validated['smtp_password'])) {
            $record->smtp_password = $validated['smtp_password'];
            $record->is_verified = false;
            $record->verified_at = null;
        }

        $record->save();

        return $record;
    }

    protected function storeEmailContent(Request $request): ManageEmailsContent
    {
        $validated = $request->validate([
            'email_type' => 'required|string|max:200',
            'email_slug' => 'required|string|max:120|unique:manage_emails_content,email_slug',
            'email_subject' => 'required|string|max:255',
            'email_content' => 'required|string',
            'macro' => 'nullable|string|max:500',
            'email_from' => 'nullable|integer|min:0',
        ]);

        return ManageEmailsContent::query()->create([
            'email_type' => $validated['email_type'],
            'email_slug' => $validated['email_slug'],
            'email_subject' => $validated['email_subject'],
            'email_content' => $validated['email_content'],
            'macro' => $validated['macro'] ?? '',
            'email_from' => (int) ($validated['email_from'] ?? 0),
        ]);
    }

    protected function updateEmailContent(Request $request, int $id): ManageEmailsContent
    {
        $record = ManageEmailsContent::query()->findOrFail($id);

        $validated = $request->validate([
            'email_type' => 'required|string|max:200',
            'email_slug' => ['required', 'string', 'max:120', Rule::unique('manage_emails_content', 'email_slug')->ignore($record->id)],
            'email_subject' => 'required|string|max:255',
            'email_content' => 'required|string',
            'macro' => 'nullable|string|max:500',
            'email_from' => 'nullable|integer|min:0',
        ]);

        $record->update([
            'email_type' => $validated['email_type'],
            'email_slug' => $validated['email_slug'],
            'email_subject' => $validated['email_subject'],
            'email_content' => $validated['email_content'],
            'macro' => $validated['macro'] ?? '',
            'email_from' => (int) ($validated['email_from'] ?? 0),
        ]);

        return $record;
    }

    protected function smtpInUse(int $smtpId): bool
    {
        return ManageEmailsContent::query()->where('email_from', $smtpId)->exists();
    }

    protected function findRecord(string $type, int $id, bool $withTrashed = false): TenantSmtpSetting|ManageEmailsContent
    {
        $modelClass = $this->types[$type];
        $query = $withTrashed ? $modelClass::withTrashed() : $modelClass::query();

        if ($type === 'smtp') {
            $query->where('tenant_id', tenant('id'));
        }

        return $query->findOrFail($id);
    }

    protected function serialize(string $type, $record, bool $full = false): array
    {
        if ($type === 'smtp') {
            $data = [
                'id' => $record->id,
                'smtp_host' => $record->smtp_host,
                'smtp_username' => $record->smtp_username,
                'from_email' => $record->from_email,
                'from_name' => $record->from_name,
                'smtp_port' => $record->smtp_port,
                'smtp_encryption' => $record->smtp_encryption,
                'is_verified' => (bool) $record->is_verified,
                'in_use' => $this->smtpInUse((int) $record->id),
            ];
            if ($full) {
                $data['smtp_password'] = '';
            }

            return $data;
        }

        $smtp = $record->email_from
            ? TenantSmtpSetting::query()->find($record->email_from)
            : null;

        return [
            'id' => $record->id,
            'email_type' => $record->email_type,
            'email_slug' => $record->email_slug,
            'email_subject' => $record->email_subject,
            'email_content' => $full ? $record->email_content : \Illuminate\Support\Str::limit(strip_tags($record->email_content), 80),
            'macro' => $record->macro,
            'email_from' => (string) ($record->email_from ?: ''),
            'smtp_label' => $smtp?->from_email ?? 'Default SMTP',
        ];
    }

    protected function assertType(string $type): void
    {
        if (! isset($this->types[$type])) {
            abort(404);
        }
    }
}
