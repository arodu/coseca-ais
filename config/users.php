<?php

use App\Model\Field\Users;
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
            'defaultRole' => Users::ROLE_STUDENT,
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
    
    //'OAuth.providers.facebook.options.clientId' => 'YOUR APP ID',
    //'OAuth.providers.facebook.options.clientSecret' => 'YOUR APP SECRET',
    //'OAuth.providers.twitter.options.clientId' => 'YOUR APP ID',
    //'OAuth.providers.twitter.options.clientSecret' => 'YOUR APP SECRET',
    //etc
];
