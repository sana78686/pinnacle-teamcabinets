<?php

// app/Mail/UserAccountVerificationMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAccountVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Account hase been Verified By Admin')
                    ->view('emails.user-account-verified')
                      ->with([
                        'user' => $this->user, // 🔁 Pass user data to the Blade view
                    ]);
    }
}

