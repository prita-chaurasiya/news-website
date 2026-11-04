<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Active Front-End Theme
    |--------------------------------------------------------------------------
    | Supported: "editorial", "portal"
    | Default: "editorial"
    |
    | "editorial": Western broadsheet layout (Playfair, serif body, expansive hero)
    | "portal": Dense Hindi TV-news portal layout (Noto Sans Devanagari, breaking ticker, mega menu)
    */
    'active' => env('SITE_THEME', 'editorial'),

    'available' => [
        'editorial' => 'Editorial (Premium Broadsheet)',
        'portal' => 'Portal (Dense Hindi TV-News Portal)',
    ],
];
