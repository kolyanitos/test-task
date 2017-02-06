<?php


namespace App\Controller;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function init(ContainerBuilder $container) {
        $this->container = $container;
        $this->twig = $this->container->get('twig');
        $this->em = $this->container->get('em');
        $this->session = $this->container->get('session');

        if ($this->container->has('user')) {
            $this->user = $this->container->get('user');
        }

        // apply twig context
        $this->context['request'] = $this->container->get('request_stack')->getMasterRequest();
        $this->context['user'] = $this->user;

        $this->twig->addGlobal('app', $this->context);
    }

    protected function htmlResponse($content = '', $status = 200, $headers = array()) {
        return new Response($content, $status, $headers);
    }

    protected function jsonResponse($data = null, $status = 200, $headers = array(), $json = false) {
        return new JsonResponse($data, $status, $headers, $json);
    }

    protected function redirectResponse($url, $status = 302, $headers = array()) {
        return new RedirectResponse($url, $status, $headers);
    }

    protected function generateUrl($route)
    {
        $route = $this->container->get('routes')->get($route);
        if ($route) {
            return $route->getPath();
        }

        throw new InvalidArgumentException("No route \"{$route}\" found");
    }

    public static function exceptionAction(FlattenException $exception) {
        return self::htmlResponse($exception->getMessage(), $exception->getStatusCode());
    }
}