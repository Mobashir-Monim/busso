<?php

define('CONFIG_CONSTANTS', [
    'app' => [
        'key'           => isset($_SERVER['APP_KEY']) ? $_SERVER['APP_KEY'] : env('APP_KEY'),
        'env'           => isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : env('APP_ENV'),
        'debug'         => (bool) isset($_SERVER['APP_DEBUG']) ? $_SERVER['APP_DEBUG'] : env('APP_DEBUG'),
        'url'           => isset($_SERVER['APP_URL']) ? $_SERVER['APP_URL'] : env('APP_URL', 'http://localhost'),
        // 'zone'          => isset($_SERVER['TIMEZONE']) ? $_SERVER['TIMEZONE'] : env('TIMEZONE', 'UTC'),
        'zone'          => 'UTC',
        'storage'       => isset($_SERVER['APP_STORAGE']) ? $_SERVER['APP_STORAGE'] : env('FILESYSTEM_DRIVER', 'local'),
    ],
    'database' => [
        'host'          => isset($_SERVER['RDS_HOSTNAME']) ? $_SERVER['RDS_HOSTNAME'] : env('DB_HOST'),
        'username'      => isset($_SERVER['RDS_USERNAME']) ? $_SERVER['RDS_USERNAME'] : env('DB_USERNAME'),
        'password'      => isset($_SERVER['RDS_PASSWORD']) ? $_SERVER['RDS_PASSWORD'] : env('DB_PASSWORD'),
        'db_name'       => isset($_SERVER['RDS_DB_NAME']) ? $_SERVER['RDS_DB_NAME'] : env('DB_DATABASE'),
    ],
    'filesystems' => [
        's3' => [
            'key'       => isset($_SERVER['BUCKET_KEY']) ? $_SERVER['BUCKET_KEY'] : env('AWS_ACCESS_KEY_ID'),
            'secret'    => isset($_SERVER['BUCKET_SECRET']) ? $_SERVER['BUCKET_SECRET'] : env('AWS_SECRET_ACCESS_KEY'),
            'region'    => isset($_SERVER['BUCKET_REGION']) ? $_SERVER['BUCKET_REGION'] : env('AWS_DEFAULT_REGION'),
            'bucket'    => isset($_SERVER['BUCKET_NAME']) ? $_SERVER['BUCKET_NAME'] : env('AWS_BUCKET'),
        ]
    ],
    'mail' => [
        'driver'        => isset($_SERVER['MAIL_DRIVER']) ? $_SERVER['MAIL_DRIVER'] : env('MAIL_DRIVER'),
        'host'          => isset($_SERVER['MAIL_HOST']) ? $_SERVER['MAIL_HOST'] : env('MAIL_HOST'),
        'port'          => isset($_SERVER['MAIL_PORT']) ? $_SERVER['MAIL_PORT'] : env('MAIL_PORT'),
        'username'      => isset($_SERVER['MAIL_USER']) ? $_SERVER['MAIL_USER'] : env('MAIL_USERNAME'),
        'password'      => isset($_SERVER['MAIL_PASS']) ? $_SERVER['MAIL_PASS'] : env('MAIL_PASSWORD'),
        'from_address'  => isset($_SERVER['MAIL_ADDRESS']) ? $_SERVER['MAIL_ADDRESS'] : env('MAIL_FROM_ADDRESS'),
        'from_name'     => isset($_SERVER['MAIL_NAME']) ? $_SERVER['MAIL_NAME'] : env('MAIL_FROM_NAME'),
    ],
]);

function getConfig($config)
{
    $parts = explode('.', $config);
    $res = CONFIG_CONSTANTS;

    for ($i = 0; $i < sizeof($parts); $i++) {
        $res = $res[$parts[$i]];
    }

    return $res;
}