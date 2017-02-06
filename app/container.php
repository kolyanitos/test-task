<?php

use Symfony\Component;

$container = new Component\DependencyInjection\ContainerBuilder();
$container->set('config', $config);
$container->set('routes', $routes);
$container->set('twig', $twig);
$container->set('em', $entityManager);

$container->register('session', Component\HttpFoundation\Session\Session::class)
    ->addMethodCall('start');
$container->register('context', Component\Routing\RequestContext::class);
$container->register('matcher', Component\Routing\Matcher\UrlMatcher::class)
    ->setArguments(array($routes, new Component\DependencyInjection\Reference('context')));
$container->register('request_stack', Component\HttpFoundation\RequestStack::class);
$container->register('controller_resolver', Component\HttpKernel\Controller\ControllerResolver::class);
$container->register('argument_resolver', Component\HttpKernel\Controller\ArgumentResolver::class);

$container->register('listener.router', Component\HttpKernel\EventListener\RouterListener::class)
    ->setArguments(
        array(
            new Component\DependencyInjection\Reference('matcher'),
            new Component\DependencyInjection\Reference('request_stack'),
        )
    );

$container->register('listener.response', Component\HttpKernel\EventListener\ResponseListener::class)
    ->setArguments(array('UTF-8'));

$container->register('listener.exception', Component\HttpKernel\EventListener\ExceptionListener::class)
    ->setArguments(array('\App\Controller\MainController::exceptionAction'));

$container->register('listener.controller', \App\Listener\ControllerListener::class)
    ->setArguments(array($container));

$container->register('dispatcher', Component\EventDispatcher\EventDispatcher::class)
    ->addMethodCall('addSubscriber', array(new Component\DependencyInjection\Reference('listener.router')))
    ->addMethodCall('addSubscriber', array(new Component\DependencyInjection\Reference('listener.response')))
    ->addMethodCall('addSubscriber', array(new Component\DependencyInjection\Reference('listener.exception')))
    ->addMethodCall('addSubscriber', array(new Component\DependencyInjection\Reference('listener.controller')));

$container->register('handler', \App\Route\Handler::class)
    ->setArguments(
        array(
            new Component\DependencyInjection\Reference('dispatcher'),
            new Component\DependencyInjection\Reference('controller_resolver'),
            new Component\DependencyInjection\Reference('request_stack'),
            new Component\DependencyInjection\Reference('argument_resolver'),
        )
    );

return $container;