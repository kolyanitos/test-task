<?php


namespace App\Listener;


use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ControllerListener implements EventSubscriberInterface
{
    private $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    public function injectContainer(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $controller[0]->init($this->container);
    }

    public function checkAuth() {
        $userId = $this->container->get('session')->get('user');

        if ($userId) {
            $this->container->set('user', $this->container->get('em')->getRepository(User::class)->find($userId));
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => array(
                array('checkAuth', 2),
                array('injectContainer', 1)
            )
        );
    }
}