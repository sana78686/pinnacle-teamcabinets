<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use App\Models\SiteSetting;
use App\Services\CloudflareTurnstileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request, CloudflareTurnstileService $turnstile)
    {
        $validated = $request->validate(array_merge([
            'name' => 'required|string|max:255',
            'from' => 'required|email|max:255',
            'message' => 'required|string|max:10000',
            'id_contact' => 'nullable|in:1,2',
            'fileUpload' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
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

        $subject = $request->id_contact == 1 ? 'Webmaster Contact' : 'Customer Service Contact';
        if ($request->filled('id_contact') === false) {
            $subject = 'Storefront contact form';
        }

        $attachmentPath = null;
        if ($request->hasFile('fileUpload')) {
            $dir = public_path('uploads/contact');
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $file = $request->file('fileUpload');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move($dir, $filename);
            $attachmentPath = 'uploads/contact/'.$filename;
        }

        ContactQuery::query()->create([
            'tenant_id' => tenant('id'),
            'name' => $validated['name'],
            'email' => $validated['from'],
            'subject' => $subject,
            'message' => $validated['message'],
            'attachment_path' => $attachmentPath,
            'ip_address' => $request->ip(),
        ]);

        $data = [
            'from' => $validated['from'],
            'bodyMessage' => $validated['message'],
            'subject' => $subject,
            'name' => $validated['name'],
        ];

        Mail::send('emails.contact', $data, function ($message) use ($data, $contactmail, $request) {
            $message->to($contactmail)
                ->replyTo($data['from'])
                ->subject($data['subject']);

            if ($request->hasFile('fileUpload')) {
                $message->attach($request->file('fileUpload')->getRealPath(), [
                    'as' => $request->file('fileUpload')->getClientOriginalName(),
                    'mime' => $request->file('fileUpload')->getMimeType(),
                ]);
            }
        });

        return redirect()->back()->with('success', 'Your message has been sent. We will get back to you soon.');
    }
}
