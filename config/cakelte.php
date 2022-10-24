<?php

use CakeLte\Style\Header;
use CakeLte\Style\Sidebar;

return [
    'CakeLte' => [
        'app-name' => 'coseca<b>AIS</b>',
        'app-logo' => 'ais-logo.png',

        'small-text' => false,
        'dark-mode' => false,
        'layout-boxed' => false,

        'header' => [
            'fixed' => false,
            'border' => true,
            'style' => Header::STYLE_DARK,
            'dropdown-legacy' => false,
        ],

        'sidebar' => [
            'fixed' => true,
            'collapsed' => false,
            'mini' => true,
            'mini-md' => true,
            'mini-xs' => false,
            'style' => Sidebar::STYLE_DARK_PRIMARY,
            'flat-style' => false,
            'legacy-style' => false,
            'compact' => false,
            'child-indent' => false,
            'child-hide-collapse' => false,
            'disabled-auto-expand' => false,
        ],

        'footer' => [
            'fixed' => false,
        ],
    ],
];