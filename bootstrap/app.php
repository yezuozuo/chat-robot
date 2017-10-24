<?php

date_default_timezone_set('Asia/Shanghai');

session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/helpers.php';

$env = new Dotenv\Dotenv(__DIR__.'/../');
$env->load();

$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();

$container['flash'] = function() {
	return new \Slim\Flash\Messages;
};

$container['view'] = function ($container) {
	$view = new \Slim\Views\Twig(__DIR__ . '/../resources/views/', [
		'cache' => false,
	]);

	$view->addExtension(new \Slim\Views\TwigExtension(
		$container->router,
		$container->request->getUri()
	));

	$view->getEnvironment()->addGlobal('flash',$container->flash);
    $view->getEnvironment()->addGlobal('session', $_SESSION);

    return $view;
};

$container['HomeController'] = function($container) {
	return new \App\Controllers\HomeController($container);
};

$container['notFoundHandler'] = function ($container) {
    return function ($request, \Slim\Http\Response $response) use ($container) {
        return $container['view']->render($response, 'errors/404.twig')->withStatus(404);
    };
};

require __DIR__ . '/../app/routes.php';