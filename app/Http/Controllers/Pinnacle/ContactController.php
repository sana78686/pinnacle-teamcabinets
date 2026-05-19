<?php

namespace App\Http\Controllers\Pinnacle;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        if ($request->filled('url')) {
            return back()->withErrors(['spam' => 'Unable to send message.']);
        }

        $validated = $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'user_phone' => 'nullable|string|max:30',
            'inquiry_type' => 'required|in:general,sales,support,dealer',
            'user_query' => 'required|string|max:2000',
        ]);

        $subjects = [
            'general' => 'General inquiry — Pinnacle contact',
            'sales' => 'Sales inquiry — Pinnacle contact',
            'support' => 'Support request — Pinnacle contact',
            'dealer' => 'Dealer inquiry — Pinnacle contact',
        ];

        $to = config('pinnacle.support_email');
        $data = [
            'from' => $validated['user_email'],
            'name' => $validated['user_name'],
            'phone' => $validated['user_phone'] ?? '—',
            'inquiry' => $subjects[$validated['inquiry_type']],
            'bodyMessage' => $validated['user_query'],
            'subject' => $subjects[$validated['inquiry_type']],
        ];

        Mail::send('emails.pinnacle-contact', $data, function ($message) use ($to, $data) {
            $message->to($to)
                ->replyTo($data['from'], $data['name'])
                ->subject($data['subject']);
        });

        return back()->with('contact_success', 'Thank you! Your message has been sent. We will respond shortly.');
    }

    public function findTenant(): View
    {
        return view('pinnacle.find-tenant', [
            'pinnacle' => config('pinnacle'),
        ]);
    }

    public function findTenantLookup(Request $request): View
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($request->email));
        $tenant = Tenant::whereRaw('LOWER(email) = ?', [$email])->first();

        if (! $tenant) {
            $user = User::whereRaw('LOWER(email) = ?', [$email])
                ->whereNotNull('tenant_id')
                ->first();
            if ($user) {
                $tenant = Tenant::find($user->tenant_id);
            }
        }

        if ($tenant) {
            $host = $tenant->domains()->first()?->domain ?? $tenant->domain_name;
            $scheme = $request->getScheme();
            $tenantUrl = $scheme.'://'.$host;
            $port = $request->getPort();
            if ($host && str_contains($host, 'localhost') && ! in_array($port, [80, 443], true)) {
                $tenantUrl .= ':'.$port;
            }

            return view('pinnacle.find-tenant', [
                'pinnacle' => config('pinnacle'),
                'found' => true,
                'tenant' => $tenant,
                'tenantUrl' => $tenantUrl,
                'email' => $request->email,
            ]);
        }

        return view('pinnacle.find-tenant', [
            'pinnacle' => config('pinnacle'),
            'found' => false,
            'email' => $request->email,
        ]);
    }
}
