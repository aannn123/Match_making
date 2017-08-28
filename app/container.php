<?php

use Slim\Container;

$container = $app->getContainer();

// Set Container And Connect Database
$container['db'] = function (Container $container) {
	$setting = $container->get('settings');

	$config = new \Doctrine\DBAL\Configuration();

	$connect = \Doctrine\DBAL\DriverManager::getConnection($setting['db'],
	$config);

	return $connect;
};

// Set Validation
$container['validator'] = function ($c) {
	$setting = $c->get('settings')['lang'];
	$param = $c['request']->getParams();
	return new \Valitron\Validator($param, [], $setting['default']);
};

$container['view'] = function ($container) {
	$setting = $container->get('settings')['view'];
	$view = new \Slim\Views\Twig($setting['path'], $setting['twig']);

	$view->addExtension(new Slim\Views\TwigExtension(
		$container->router, $container->request->getUri())
	);

	$view->getEnvironment()->addGlobal('old', @$_SESSION['old']);
	unset($_SESSION['old']);
	$view->getEnvironment()->addGlobal('errors', @$_SESSION['errors']);
	unset($_SESSION['errors']);

	if (@$_SESSION['login']) {
		$view->getEnvironment()->addGlobal('login', $_SESSION['login']);
	}

	if (@$_SESSION['search']) {
		$view->getEnvironment()->addGlobal('search', $_SESSION['search']);
		unset($_SESSION['search']);
	}

	if (@$_SESSION['back']) {
		$view->getEnvironment()->addGlobal('back', $_SESSION['back']);
	}

	$view->getEnvironment()->addGlobal('flash', $container->flash);

	return $view;
};

$container['flash'] = function ($container) {
	return new \Slim\Flash\Messages;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['client'] = function ($container) {
   $settings = $container->get('settings')['reporting'];

   return new GuzzleHttp\Client([
       'base_uri' => $settings['base_uri'],
       'headers'  => $settings['headers']
   ]);
};
$container['fs'] = function ($c) {
	$setting = $c->get('settings')['flysystem'];
    $adapter = new \League\Flysystem\Adapter\Local($setting['path']);
    $filesystem = new \League\Flysystem\Filesystem($adapter);
    return $filesystem;
};

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
		return $response->withRedirect($request->getUri()->getBasePath().'/404');
    };
};
