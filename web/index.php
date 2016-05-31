<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__."/../app/service/MainService.php";

$app = new Silex\Application();

$app['pictureDao'] = function() use ($app) {
    return new PictureDao($app['db']);
};

$app['mainService'] = function () use ($app) {
    return new MainService($app['pictureDao']);
};

$app['db'] = function() {
    return (new \MongoDB\Client())->selectDatabase("kotya");
};

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../app/view/'
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app['debug'] = true;

$app->get('/{pictureId}', function ($pictureId) {
    return 'Hello!';
})->assert('pictureId', '\d+');

$app->get('/', function ($main) use ($app) {
    return $app['twig']->render('Main.html', array(
            'name' => 'file',
            'file' => '1'
        )
    );
})->convert('main', 'mainService:index');

$app->get('/login', function () use ($app) {
    return $app['twig']->render('login.html');
});

$app->error(function (\MongoDB\Driver\Exception\ConnectionTimeoutException $e) use ($app) {
    error_log("Database timeout exception. ".$e->getCode()." ".$e->getMessage());
    if ($app['debug'] === false) {
        exit("Database error.");
    }
});

$app->run();
