<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $db = new PDO($settings['host'].$settings['dbName'], $settings['userName']);
    return $db;
};
