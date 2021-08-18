<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['LOG_CHANNEL'] : env('LOG_CHANNEL', 'stack'),
    // 'default' => 'cloudwatch',

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['LOG_LEVEL'] : env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['LOG_LEVEL'] : env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['LOG_LEVEL'] : env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['LOG_LEVEL'] : env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['LOG_LEVEL'] : env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        'cloudwatch' => [
            'driver' => 'custom',
            'via' => \App\Logging\CloudWatchLoggerFactory::class,
            'sdk' => [
              'region' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['BUCKET_REGION'] : env('AWS_DEFAULT_REGION', 'ap-southeast-1'),
              'version' => 'latest',
              'credentials' => [
                'key' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['BUCKET_KEY'] : env('AWS_ACCESS_KEY_ID'),
                'secret' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['BUCKET_SECRET'] : env('AWS_SECRET_ACCESS_KEY')
              ]
            ],
            'retention' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['LOG_RETENTION'] : env('LOG_RETENTION',7),
            'level' => isset($_SERVER['SERVER_CONFIG_EXISTS']) ? $_SERVER['LOG_LEVEL'] : env('LOG_LEVEL','info')
          ],
    ],

];
