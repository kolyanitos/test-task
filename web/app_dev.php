<?php

require_once '../app/bootstrap.php';
$routes = require_once APP_DIR . '/routes.php';
$container = require_once APP_DIR . '/container.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$handler = $container->get('handler');
$response = $handler->handle($request);
$response->send();
