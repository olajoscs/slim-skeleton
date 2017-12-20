<?php

return [
    'database' => [
        'type'     => getenv('DB_TYPE') ?: 'mysql',
        'host'     => getenv('DB_HOST') ?: 'localhost',
        'username' => getenv('DB_USER') ?: 'secret',
        'password' => getenv('DB_PASSWORD') ?: 'secret',
        'database' => getenv('DB_DATABASE') ?: 'secret',
        'options'  => [
            PDO::ATTR_PERSISTENT         => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ],
    ],

    'error' => [
        'display' => getenv('ERROR_DISPLAY') ?: true,
    ],

    'timezone' => getenv('TIMEZONE') ?: 'Europe/Budapest',
];
