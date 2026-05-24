<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use App\Models\SiteSetting;
use App\Models\SupportMessage;
use App\Models\SupportThread;
use App\Services\CloudflareTurnstileService;
use App\Services\SupportChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function send(Request $request, CloudflareTurnstileService $turnstile)
    {
        $hearOptions = array_keys(config('tenant_storefront.hear_about_options', []));
        $contactOptions = array_keys(config('tenant_storefront.best_contact_options', []));

        $validated = $request->validate(array_merge([
            'first_name' => 'required|string|max:120',
            'last_name' => 'required|string|max:120',
            'from' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'message' => 'required|string|max:10000',
            'hear_about_us' => ['nullable', 'string', Rule::in($hearOptions)],
            'best_contact_method' => ['required', 'string', Rule::in(collect($contactOptions)->keys()->filter(fn ($k) => $k !== '')->values()->all())],
            'newsletter_subscribe' => 'nullable|boolean',
            'url' => 'nullable|string|size:0',
        ], $turnstile->validationRules()));

        if (! empty($request->input('url'))) {
            return redirect()->back()->withErrors(['spam' => 'Spam detected']);
        }

        $settings = SiteSetting::first();
        $contactmail = $settings?->contactus_email ?: $settings?->email;

        if (! $contactmail) {
            return redirect()->back()->withErrors(['email' => 'Contact email is not configured. Please try again later.']);
        }

        $fullName = trim($validated['first_name'].' '.$validated['last_name']);
        $subject = 'Storefront contact form';

        $metaLines = [];
        if (! empty($validated['hear_about_us'])) {
            $metaLines[] = 'How they heard about us: '.(config('tenant_storefront.hear_about_options')[$validated['hear_about_us']] ?? $validated['hear_about_us']);
        }
        $metaLines[] = 'Best way to contact: '.(config('tenant_storefront.best_contact_options')[$validated['best_contact_method']] ?? $validated['best_contact_method']);
        $metaLines[] = 'Newsletter: '.(! empty($validated['newsletter_subscribe']) ? 'Yes' : 'No');
        $metaLines[] = 'Phone: '.$validated['phone'];

        $storedMessage = trim($validated['message']."\n\n---\n".implode("\n", $metaLines));

        ContactQuery::query()->create([
            'tenant_id' => tenant('id'),
            'name' => $fullName,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['from'],
            'phone' => $validated['phone'],
            'hear_about_us' => $validated['hear_about_us'] ?? null,
            'best_contact_method' => $validated['best_contact_method'],
            'newsletter_subscribe' => ! empty($validated['newsletter_subscribe']),
            'subject' => $subject,
            'message' => $storedMessage,
            'ip_address' => $request->ip(),
        ]);

        $data = [
            'from' => $validated['from'],
            'bodyMessage' => $storedMessage,
            'subject' => $subject,
            'name' => $fullName,
        ];

        Mail::send('emails.contact', $data, function ($message) use ($data, $contactmail) {
            $message->to($contactmail)
                ->replyTo($data['from'])
                ->subject($data['subject']);
        });

        return redirect()->back()->with('success', 'Thank you! Your message has been sent. We will get back to you soon.');
    }
}
