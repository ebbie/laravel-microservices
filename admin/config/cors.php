<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'api/user', 'api/user', 'api/login'],

    'allowed_methods' => ['POST', 'GET', 'DELETE', 'PUT', '*'],

    'allowed_origins' => ['http://localhost:3000', '*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['X-Custom-Header', 'Upgrade-Insecure-Requests', '*'],

    'exposed_headers' => false,

    'max_age' => false,

    'supports_credentials' => true,

];
