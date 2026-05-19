<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send all email
    | messages unless another mailer is explicitly specified when sending
    | the message. All additional mailers can be configured within the
    | "mailers" array. Examples of each type of mailer are provided.
    |
    */

    'default' => env('MAIL_MAILER', 'log'),

    /*
    | Mailer used for Pinnacle / super-admin (central app) emails.
    | Falls back to "smtp" when CENTRAL_MAIL_MAILER is not set.
    */
    'central_mailer' => env('CENTRAL_MAIL_MAILER', 'smtp'),

    /*
    | Inbox for Pinnacle super-admin (tenant registered, central contact form, etc.).
    | CENTRAL_MAIL in .env is the primary key; SUPERADMIN_EMAIL is a fallback.
    */
    'superadmin' => env('CENTRAL_MAIL', env('SUPERADMIN_EMAIL', 'superadmin@pinnacle-system.com')),

    /*
    | From address for central (Pinnacle) outgoing mail — typically Gmail in .env.
    */
    /*
    | Outgoing From for central alerts — defaults to platform no-reply (MAIL_FROM_*).
    | CENTRAL_MAIL is the inbox that receives mail, not the sender address.
    */
    'central_from' => [
        'address' => env('CENTRAL_MAIL_FROM_ADDRESS', env('MAIL_FROM_ADDRESS', 'no-reply@apimstec.com')),
        'name' => env('MAIL_FROM_NAME', config('pinnacle.name', 'Pinnacle')),
    ],

    'reply_to' => [
        'address' => env('MAIL_REPLY_TO_ADDRESS', env('CENTRAL_MAIL', env('MAIL_FROM_ADDRESS'))),
        'name' => env('MAIL_REPLY_TO_NAME', env('MAIL_FROM_NAME', 'Pinnacle')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers that can be used
    | when delivering an email. You may specify which one you're using for
    | your mailers below. You may also add additional mailers if needed.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "resend", "log", "array",
    |            "failover", "roundrobin"
    |
    */

    'mailers' => [

        'smtp' => [
            'transport' => 'smtp',
            'scheme' => env('MAIL_SCHEME'),
            'url' => env('MAIL_URL'),
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 2525),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
            'stream' => [
                'ssl' => [
                    'verify_peer' => filter_var(env('MAIL_VERIFY_PEER', true), FILTER_VALIDATE_BOOLEAN),
                    'verify_peer_name' => filter_var(env('MAIL_VERIFY_PEER', true), FILTER_VALIDATE_BOOLEAN),
                    'allow_self_signed' => filter_var(env('MAIL_ALLOW_SELF_SIGNED', false), FILTER_VALIDATE_BOOLEAN),
                ],
            ],
        ],

        /*
        | Central app uses the same platform SMTP (no-reply@apimstec.com) unless CENTRAL_MAIL_* overrides.
        */
        'central' => [
            'transport' => 'smtp',
            'host' => env('CENTRAL_MAIL_HOST', env('MAIL_HOST', 'mail.apimstec.com')),
            'port' => env('CENTRAL_MAIL_PORT', env('MAIL_PORT', 465)),
            'encryption' => env('CENTRAL_MAIL_ENCRYPTION', env('MAIL_ENCRYPTION', 'ssl')),
            'username' => env('CENTRAL_MAIL_USERNAME', env('MAIL_USERNAME')),
            'password' => env('CENTRAL_MAIL_PASSWORD', env('MAIL_PASSWORD')),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', parse_url(env('APP_URL', 'http://localhost'), PHP_URL_HOST)),
            'stream' => [
                'ssl' => [
                    'verify_peer' => filter_var(env('MAIL_VERIFY_PEER', true), FILTER_VALIDATE_BOOLEAN),
                    'verify_peer_name' => filter_var(env('MAIL_VERIFY_PEER', true), FILTER_VALIDATE_BOOLEAN),
                    'allow_self_signed' => filter_var(env('MAIL_ALLOW_SELF_SIGNED', false), FILTER_VALIDATE_BOOLEAN),
                ],
            ],
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all emails sent by your application to be sent from
    | the same address. Here you may specify a name and address that is
    | used globally for all emails that are sent by your application.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

];
