<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'cuaca' => [
    'default_city' => env('WEATHER_DEFAULT_CITY', 'Denpasar'),
    'country_code' => env('WEATHER_COUNTRY_CODE', 'ID'),
    'timezone'     => env('WEATHER_TIMEZONE', 'Asia/Makassar'),
    'ttl'          => env('WEATHER_TTL', 900),

    'cities' => [
        'Denpasar',
        'Kuta',
        'Ubud',
        'Sanur',
        'Nusa Dua',
        'Canggu',
        'Jimbaran',
        'Tabanan',
        'Gianyar',
        'Singaraja',
        'Bangli',
        'Karangasem',
        'Klungkung',
        'Negara',
        ],
    ],

];
