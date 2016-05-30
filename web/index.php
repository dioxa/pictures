<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__."/../app/service/Main.php";

$app = new Silex\Application();

$app['Main'] = function () {
    return new Main();
};

$app['debug'] = true;

$app->get('/{pictureId}', function ($pictureId) {
    return 'Hello!';
})->assert('pictureId', '\d+');

$app->get('/', function (Main $main) {

    return $main;
})->convert('Main', 'Main:index');

$app->get('/login', function () {
    return 'login';
});

$app->run();
