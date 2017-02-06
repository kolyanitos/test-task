<?php

$routeCollection = new \Symfony\Component\Routing\RouteCollection();
$routes = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(APP_DIR . '/config/routes.yml'));
foreach ($routes as $name => $route) {
    $routeCollection->add($name, new \Symfony\Component\Routing\Route(
        $route['path'], [
            '_controller' => $route['controller']
        ]
    ));
}

return $routeCollection;