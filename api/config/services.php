<?php

return [

    'money' => [
        'decimals' => 2,
        'currency_multiplier' => env('CURRENCY_MULTIPLIER', 100),
        'percent_multiplier' => env('PERCENT_MULTIPLIER', 10000),
    ],

    'awesome_api' => [
        'base_url' => env('AWESOME_API_BASE_RUL', 'https://economia.awesomeapi.com.br')
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
