<?php

use Cake\Console\ConsoleIo;

return [
    'AdminTools' => [
        'backupDb' => [
            'enabled' => filter_var(env('AT_BACKUP_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
        ],
    ],
];
