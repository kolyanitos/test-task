<?php


namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class Controller
{
    /**
     * @var ContainerBuilder $container
     */
    protected $container;

    /**
     * @var \Twig_Environment $twig
     */
    protected $twig;

    /**
     * @var EntityManager $em
     */
    protected $em;

    /**
     * @var null|User $user
     */
    protected $user = null;

    /**
     * @var Session $session
     */
    protected $session;

    /** @var array Twig vars */
    protected $context = [];

    public abstract function init(ContainerBuilder $container);
}