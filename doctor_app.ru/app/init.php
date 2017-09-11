<?php

$loader = require_once __DIR__ . '/../vendor/autoload.php';
$loader = require_once __DIR__ . '/../app/Controllers/MainController.php';
$loader = require_once __DIR__ . '/../app/Controllers/UserController.php';
$loader = require_once __DIR__ . '/../app/Models/UserModel.php';
$loader = require_once __DIR__ . '/../app/Models/DirectionModel.php';
$loader = require_once __DIR__ . '/../app/forms/UserForm.php';
//$loader = require_once __DIR__ . '/../app/Models/UserProvider.php';
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;


$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'doctor_app',
            'user' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
        ),
    )
);

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new Silex\Provider\LocaleServiceProvider());


$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/views',
));
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());

//$app->register(new Silex\Provider\SecurityServiceProvider(), array(
//    'security.firewalls' => array(
//        'foo' => array('pattern' => '^/foo'), // Example of an url available as anonymous user
//        'default' => array(
//            'pattern' => '^.*$',
//            'anonymous' => true, // Needed as the login path is under the secured area
//            'form' => array('login_path' => '/user/login', 'check_path' => '/admin/login_check'),
//            'logout' => array('logout_path' => '/logout'), // url to call for logging out
//            'users' => function ($app) {
//                // Specific class App\User\UserProvider is described below
//                return new Models\UserProvider($app['db']);
//            },
//        ),
//    ),
//    'security.access_rules' => array(
////        array('^/$', 'ROLE_USER'),
////        array('/admin/.+$', 'ROLE_ADMIN'),
////        array('^/admin$', 'ROLE_ADMIN'),
//        array('^/foo$', ''), // This url is available as anonymous user
//    )
//));


$app['user_forms'] = function ($app) {
    return new forms\UserForm($app['form.factory']);
};

$app['main_controller'] = function ($app) {
    return new Controllers\MainController(new Models\UserModel($app['db']), new Models\DirectionModel($app['db']));
};

$app['user_controller'] = function ($app) {
    return new Controllers\UserController(new Models\UserModel($app['db']), new Models\DirectionModel($app['db']));
};

require 'routes.php';
$app->run();