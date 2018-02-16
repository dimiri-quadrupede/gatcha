<?php

namespace AppBundle\Listener ;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\InNavEntry;

class PageLoadListener extends controller
{
	protected $request;
	protected $response;
	protected $allowLocale;
	protected $locale;
	protected $cookie = null;
        protected $em ;

	public function __construct(ContainerInterface $container, EntityManagerInterface $em)//, )//$allowLocale,$locale
	{
		//$this->allowLocale = $allowLocale;
		//$this->locale = $locale;
		$this->container = $container;
                $this->em = $em ;
	}

	public function onKernelRequest(GetResponseEvent $event)
	{
            //get datas
            $this->request = $event->getRequest();
			
			//if(is_object($this->container->get('security.context')->getToken()))
			if(is_object($this->container->get('security.token_storage')->getToken()))
			{
				//$user = $this->container->get('security.context')->getToken()->getUser();
				$user = $this->container->get('security.token_storage')->getToken()->getUser();
				
				$env = $this->container->getParameter('kernel.environment');
				
				if(is_object($user) && $user->getId()!="")
				{
					if(!$this->request->isXmlHttpRequest())
					{
						if($env !== 'dev' && $env !== 'test')
						{
							$nav = new InNavEntry();

							$nav->setUri($this->request->getUri());
							$nav->setNameUser($user->getUsername());

							$this->em->persist($nav);

							error_log( $this->request->getContentType()." - serverIP :: ". $_SERVER['SERVER_ADDR']." - clientIP :: ". $this->request->getClientIp()." - page visité :: ".  $this->request->getUri());

							$this->em->flush();
						}
					}
				}
			}
            //set the user locale
            $this->setLocale();
	}

	public function onKernelResponse(FilterResponseEvent $event)
	{
		//prepare response
		$this->response = $event->getResponse();
                
		if($this->cookie!=null)
			$this->response->headers->setCookie($this->cookie);
	}

	private function setLocale()
	{
		$session = $this->request->getSession();
		$cookie = $this->request->cookies;

		//if($this->container->get('security.context')->getToken())
		//	$user = $this->container->get('security.context')->getToken()->getUser();
		if(is_object($this->container->get('security.token_storage')->getToken()))
			$user = $this->container->get('security.token_storage')->getToken()->getUser();
		//test session
		/**
			if($this->request->has('_locale'))
			{
				$locale = $this->request->getlocale();
			}
		else
		**/
			if(isset($user) && is_object($user) && $session->has('_locale'))
			{
				$locale = $session->get('_locale');
			}
		else
			if ($cookie->has('_locale'))
			{

				$locale = $cookie->get('_locale');
			}
		else
			if(isset($user) && is_object($user))
			{

				$locale = $user->getLocale();
			}
		else
			{
				$locale = $this->container->getparameter('locale');

			}
/**
		if(!in_array($locale, $this->allowLocale))
			$locale = $this->locale;
**/

			if ($cookie->has('_locale'))
				$session->set('_locale',$locale);
		else
		{
			$newCookie = new Cookie('_locale', $locale, time() + 3600 * 24 * 7 * 365);
			$this->cookie = $newCookie;
		}
                
		if(!is_null($session))
                    $session->set('_locale', $locale);
                
		$this->request->setLocale($locale);
	}

}