<?php

return [
    'connection' => [
        'username' => env('PARASUT_USERNAME'),
        'password' => env('PARASUT_PASSWORD'),
        'is_stage' => env('PARASUT_IS_STAGE'),
        'client_id' => env('PARASUT_CLIENT_ID'),
        'company_id' => env('PARASUT_COMPANY_ID'),
        'redirect_uri' => env('PARASUT_REDIRECT_URI'),
        'client_secret' => env('PARASUT_CLIENT_SECRET'),
    ]
];
