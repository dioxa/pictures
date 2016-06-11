<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__."/../app/service/MainService.php";
require_once __DIR__."/../app/service/RegistrationService.php";
require_once __DIR__."/../app/service/LoginService.php";
require_once __DIR__."/../app/model/UserDao.php";

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['pictureDao'] = function() use ($app) {
    return new PictureDao($app['db']);
};

$app['mainService'] = function () use ($app) {
    return new MainService($app['pictureDao']);
};

$app['userDao'] = function() use ($app) {
    return new UserDao($app['db']);
};

$app['registrationService'] = function () use ($app) {
    return new RegistrationService($app["userDao"]);
};

$app['loginService'] = function () use ($app) {
    return new LoginService($app["userDao"]);
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

$app->post('/auth', function (Request $request) use ($app) {
    if ($app['loginService']->auth($request->get('username'), $request->get('pass')) === true) {
        $app['session']->set('user', array('username' => $request->get('username')));
        return $app->redirect('/account');
    }
});

$app->get('/account', function () use ($app) {
    if (null !== $user = $app['session']->get('user')) {
        return "Hello {$user['username']}";
    }
    return $app->redirect('/login');
});

$app->get('/registration', function () use ($app) {
    return $app['twig']->render('registration.html');
});

$app->post('/reg', function (Request $request) use ($app) {
    $userInfo = $request->get('userInfo');
    $app['registrationService']->createNewUser($userInfo);
    return $app->redirect('/login');
});

$app->error(function (\MongoDB\Driver\Exception\ConnectionTimeoutException $e) use ($app) {
    error_log("Database timeout exception. ".$e->getCode()." ".$e->getMessage());
    if ($app['debug'] === false) {
        exit("Database error.");
    }
});

$app->run();
