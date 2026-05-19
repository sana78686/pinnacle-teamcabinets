<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageEmailsDetail extends Model
{
    protected $table = 'manage_emails_details';

    protected $fillable = [
        'smtp_host',
        'smtp_user',
        'smtp_pass',
        'smtp_port',
        'smtp_encryption',
        'smtp_from_email',
    ];

    protected $hidden = ['smtp_pass'];
}
