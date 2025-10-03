<?php
return [
    'propel' => [
        'database' => [
            'connections' => [
                'default' => [
                    'adapter' => 'pgsql',
                    'dsn' => 'pgsql:host=localhost;port=5432;dbname=chinook',
                    'user' => 'mit',
                    'password' => '123456',
                    'settings' => [
                        'charset' => 'utf8'
                    ]
                ]
            ]
        ]
    ]
];
