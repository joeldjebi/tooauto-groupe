<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    |
    | The default locale is served without a URL prefix (/), the others are
    | served under their own prefix (/en).
    |
    */

    'locales' => ['fr', 'en'],

    'default_locale' => 'fr',

    /*
    |--------------------------------------------------------------------------
    | Company details
    |--------------------------------------------------------------------------
    */

    'contact' => [
        'email' => env('SITE_CONTACT_EMAIL', 'hello@tooautogroup.com'),
        'mobile' => '+225 07 07 08 08 39',
        'landline' => '+225 27 33 71 29 14',
        'address' => 'Abidjan, Cocody Angré, derrière la CNPS',
        'postal_address' => '25 BPM 001264 Abidjan 25',
        'website' => 'www.tooautogroup.com',
    ],

    'legal' => [
        'rcc' => 'CI-ABJ-03-2025-B12-01776',
        'cc' => '2502260F',
        'parent_company' => 'BWAN HOLDING',
    ],

    /*
    |--------------------------------------------------------------------------
    | App store links
    |--------------------------------------------------------------------------
    |
    | Leave empty until the apps are published: the site then shows a
    | "coming soon" state instead of a dead link.
    |
    */

    'stores' => [
        'google_play' => env('SITE_GOOGLE_PLAY_URL'),
        'app_store' => env('SITE_APP_STORE_URL'),
    ],

];
