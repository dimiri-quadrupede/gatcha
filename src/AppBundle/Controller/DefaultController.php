<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Personnage controller.
 *
 * @Route("")
 */
class DefaultController extends Controller
{
    
    /**
     * @Route("/", name="homepage")
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction(Request $request)
    {
        
        return $this->render('AppBundle:Default:index.html.twig', [
            //'base_dir' => ''
            //'base_dir' => realpath($this->getgetParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'base_dir' => realpath($this->get('kernel')->getRootDir()).DIRECTORY_SEPARATOR,
        ]); 
    }
}
