<?php

use App\Model\Field\UserRole;
use App\Model\Table\AppUsersTable;




return [
    'Users' => [
        // Table used to manage users
        'table' => AppUsersTable::class,
        // Controller used to manage users plugin features & actions
        'controller' => 'CakeDC/Users.Users',
        'Social' => [
            'login' => false,
        ],
        'Registration' => [
            'defaultRole' => UserRole::STUDENT->value,
            'active' => true,
            'reCaptcha' => true,
        ],
        'reCaptcha' => [
            'key' => env('RECAPTCHA_CLIENT_KEY'),
            'secret' => env('RECAPTCHA_CLIENT_SECRET'),
            'registration' => true,
            'login' => false,
        ],
        'Tos' => [
            'required' => false,
        ],
        'Email' => [
            // determines if the user should include email
            'required' => true,
            // determines if registration workflow includes email validation
            'validate' => false,
        ],
    ],
    'Auth' => [
        'Identifiers' => [
            'Password' => [
                'resolver' => [
                    'finder' => 'auth',
                ],
            ],
            'Social' => [
                'authFinder' => 'auth',
            ],
            'Token' => [
                'resolver' => [
                    'finder' => 'auth',
                ],
            ],
        ],
    ],
    
    //'OAuth.providers.facebook.options.clientId' => 'YOUR APP ID',
    //'OAuth.providers.facebook.options.clientSecret' => 'YOUR APP SECRET',
    //'OAuth.providers.twitter.options.clientId' => 'YOUR APP ID',
    //'OAuth.providers.twitter.options.clientSecret' => 'YOUR APP SECRET',
    //etc
];
