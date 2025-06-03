<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Coingecko API Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for the Coingecko API.
    | You can set your API key here if required, but Coingecko does not
    | require an API key for public endpoints. You can also set up other
    | configurations such as the base URL, and precision.
    |
    */

    'api_base_url' => env('COINGECKO_API_BASE_URL', 'https://api.coingecko.com/api/v3'),

    'precision' => env('COINGECKO_PRECISION', 'full'),
];
