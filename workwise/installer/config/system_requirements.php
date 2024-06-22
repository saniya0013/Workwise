<?php


return [
    'phpversion' => [
        'min' => '7.4',
        'max' => '8.3',
        'excludeRange' => [],
    ],

    'mysqlversion' => [
        'min' => '5.5',
        'max' => '8.3',
        'excludeRange' => [],
    ],

    'mariadbversion' => [
        'min' => '5.5',
        'max' => '11.3',
        'excludeRange' => [],
    ],

    'webserver' => ['Apache', 'nginx', 'IIS'],
];
