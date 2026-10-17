<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */


return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),

    'App' => [
        'base' => env('APP_BASE', false),
    ],

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', 'b6b6b4f2d06445f6a00bf04c4ed00e770a05b710'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'url' => env('DATABASE_URL', null),
        ],

        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'url' => env('DATABASE_TEST_URL', 'sqlite://127.0.0.1/tests.sqlite'),
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'className' => env('EMAIL_CLASSNAME', 'Smtp'),
            'host' => env('EMAIL_HOST', 'localhost'),
            'port' => env('EMAIL_PORT', 1025),
            'username' => env('EMAIL_USERNAME'),
            'password' => env('EMAIL_PASSWORD'),
            'client' => null,
            'tls' => filter_var(env('EMAIL_TLS', false), FILTER_VALIDATE_BOOLEAN),
        ],
    ],
];
