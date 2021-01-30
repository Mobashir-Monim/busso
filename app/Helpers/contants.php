<?php

define('SERVER_CONFIG_EXISTS', isset($_SERVER['SERVER_CONFIG_EXISTS']));

define('CONFIG_CONSTANTS', [
    'app' => [
        'key'           => SERVER_CONFIG_EXISTS ? $_SERVER['APP_KEY'] : env('APP_KEY'),
        'env'           => SERVER_CONFIG_EXISTS ? $_SERVER['APP_ENV'] : env('APP_ENV'),
        'debug'         => (bool) (SERVER_CONFIG_EXISTS ? $_SERVER['APP_DEBUG'] : env('APP_DEBUG')),
        'url'           => SERVER_CONFIG_EXISTS ? $_SERVER['APP_URL'] : env('APP_URL', 'http://localhost'),
        'zone'          => SERVER_CONFIG_EXISTS ? $_SERVER['TIMEZONE'] : env('TIMEZONE', 'UTC'),
        // 'zone'          => 'UTC',
        'storage'       => SERVER_CONFIG_EXISTS ? $_SERVER['APP_STORAGE'] : env('FILESYSTEM_DRIVER', 'local'),
    ],
    'database' => [
        'host'          => SERVER_CONFIG_EXISTS ? $_SERVER['RDS_HOSTNAME'] : env('DB_HOST'),
        'username'      => SERVER_CONFIG_EXISTS ? $_SERVER['RDS_USERNAME'] : env('DB_USERNAME'),
        'password'      => SERVER_CONFIG_EXISTS ? $_SERVER['RDS_PASSWORD'] : env('DB_PASSWORD'),
        'db_name'       => SERVER_CONFIG_EXISTS ? $_SERVER['RDS_DB_NAME'] : env('DB_DATABASE'),
    ],
    'filesystems' => [
        's3' => [
            'key'       => SERVER_CONFIG_EXISTS ? $_SERVER['BUCKET_KEY'] : env('AWS_ACCESS_KEY_ID'),
            'secret'    => SERVER_CONFIG_EXISTS ? $_SERVER['BUCKET_SECRET'] : env('AWS_SECRET_ACCESS_KEY'),
            'region'    => SERVER_CONFIG_EXISTS ? $_SERVER['BUCKET_REGION'] : env('AWS_DEFAULT_REGION'),
            'bucket'    => SERVER_CONFIG_EXISTS ? $_SERVER['BUCKET_NAME'] : env('AWS_BUCKET'),
        ]
    ],
    'mail' => [
        'driver'        => SERVER_CONFIG_EXISTS ? $_SERVER['MAIL_DRIVER'] : env('MAIL_DRIVER'),
        'host'          => SERVER_CONFIG_EXISTS ? $_SERVER['MAIL_HOST'] : env('MAIL_HOST'),
        'port'          => SERVER_CONFIG_EXISTS ? $_SERVER['MAIL_PORT'] : env('MAIL_PORT'),
        'username'      => SERVER_CONFIG_EXISTS ? $_SERVER['MAIL_USER'] : env('MAIL_USERNAME'),
        'password'      => SERVER_CONFIG_EXISTS ? $_SERVER['MAIL_PASS'] : env('MAIL_PASSWORD'),
        'from_address'  => SERVER_CONFIG_EXISTS ? $_SERVER['MAIL_ADDRESS'] : env('MAIL_FROM_ADDRESS'),
        'from_name'     => SERVER_CONFIG_EXISTS ? $_SERVER['MAIL_NAME'] : env('MAIL_FROM_NAME'),
    ],
]);

function getConfig($config)
{
    try {
        $parts = explode('.', $config);
        $res = CONFIG_CONSTANTS;

        for ($i = 0; $i < sizeof($parts); $i++) {
            $res = $res[$parts[$i]];
        }

        return $res;
    } catch (\Throwable $th) {
        return null;
    }
}

function printConf()
{
    return CONFIG_CONSTANTS;
}