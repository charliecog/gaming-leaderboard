<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        'db' => [
            'host' => 'mysql:host=192.168.20.20;',
            'dbName' =>'dbname=gaming_score',
            'userName' =>'root',
        ]
    ],
];
