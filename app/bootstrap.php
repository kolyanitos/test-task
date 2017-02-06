<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;

define('APP_DIR', __DIR__);

// Doctrine ORM
$config = Yaml::parse(file_get_contents(__DIR__ . '/config/app.yml'));
$entityManager = EntityManager::create(
    $config['orm'],
    Setup::createAnnotationMetadataConfiguration(
        [
            __DIR__ . '/../src/App/Entity',
        ],
        $config['dev_mode']
    )
);

// Twig
$loader = new Twig_Loader_Filesystem(__DIR__ . '/views');
$twig = new Twig_Environment($loader, array(
    'debug' => $config['dev_mode'],
    //'cache' => __DIR__ . '/cache',
));
$twig->addExtension(new Twig_Extension_Debug());