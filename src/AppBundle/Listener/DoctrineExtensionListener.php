<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker ;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DoctrineExtensionListener implements ContainerAwareInterface
{

	/**
	 * @var ContainerInterface
	 */
	protected $container;

	public function setContainer( ContainerInterface $container = null )
	{
		$this->container = $container;
	}

	public function onLateKernelRequest( GetResponseEvent $event )
	{
		$translatable = $this->container->get('gedmo.listener.translatable');
		$translatable->setTranslatableLocale($event->getRequest()->getLocale());
	}
        
        

	public function onKernelRequest( GetResponseEvent $event )
	{
            $securityContext = $this->container->get('security.context', ContainerInterface::NULL_ON_INVALID_REFERENCE);
            //$securityContext = $this->container->get('security.authorization_checker', ContainerInterface::NULL_ON_INVALID_REFERENCE);

            if( null !== $securityContext )
            {
                $token  = $securityContext->getToken() ;
                
                if(null !== $token && $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
                {
                    $loggable = $this->container->get('gedmo.listener.loggable');
                    $loggable->setUsername($securityContext->getToken()->getUsername());
                }
            }
	}

}
