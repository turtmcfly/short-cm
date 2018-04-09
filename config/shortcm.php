<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Short.cm API URL
    |--------------------------------------------------------------------------
    |
    | The URL to the Short.cm service API.
    |
    */

    'api'       => env('SHORTCM_API', 'https://api.short.cm'),

    /*
    |--------------------------------------------------------------------------
    | Short.cm Custom Domain
    |--------------------------------------------------------------------------
    |
    | If a custom domain is being used with a short url, it must be entered here.
    |
    | @see https://short.cm/features/multiple-domains/
    |
    */

    'domain'    => env('SHORTCM_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Short.cm API Key
    |--------------------------------------------------------------------------
    |
    | The API key in order to access the Short.cm API.
    |
    */
    'key'       => env('SHORTCM_KEY'),
];