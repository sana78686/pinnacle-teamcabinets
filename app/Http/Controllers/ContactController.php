<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'id_contact' => 'required|in:1,2',
            'from' => 'required|email',
            'message' => 'required|string',
            'fileUpload' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'url' => 'nullable|string|size:0',  // honeypot field, must be empty
            'token' => 'required|string',
        ]);

        // If honeypot filled, reject
        if (!empty($request->input('url'))) {
            return redirect()->back()->withErrors(['spam' => 'Spam detected']);
        }
$settings = SiteSetting::first();
$contactmail = $settings?->contactus_email;


        // Determine recipient email based on id_contact
        // $recipient = $request->id_contact == 1 ? 'zikrzikr012@gmail.com' : 'saifullah.khalid@netopz.com';

       $data = [
    'from' => $validated['from'],
    'bodyMessage' => $validated['message'], // renamed from 'message' to 'bodyMessage'
    'subject' => $request->id_contact == 1 ? 'Webmaster Contact' : 'Customer Service Contact',
];


        // Send mail with attachment if uploaded
        Mail::send('emails.contact', $data, function ($message) use ($data, $contactmail, $request) {
            $message->to($contactmail)
                    ->from($data['from'])
                    ->subject($data['subject']);

            if ($request->hasFile('fileUpload')) {
                $message->attach($request->file('fileUpload')->getRealPath(), [
                    'as' => $request->file('fileUpload')->getClientOriginalName(),
                    'mime' => $request->file('fileUpload')->getMimeType(),
                ]);
            }
        });

        return redirect()->back()->with('success', 'Your message has been sent!');
    }
}
