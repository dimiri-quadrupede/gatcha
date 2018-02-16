<?php
namespace AppBundle\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Description of BaseController
 *
 * @author lmq-dimitri
 */
class BaseController extends Controller
{
    /**
     * return Array
     * (
     * [0] => MyBundle\Controller\MyController::myAction
     * [1] => Acme
     * [2] => My
     * [3] => My
     * [4] => my
     * )
     * @param Request $request
     */
    protected function getRequestPath(Request $request = null)
    {
        if(is_null($request))
            $request = $this->get("_request");
        
        //echo $request->attributes->get('_controller');
        
        $matches    = array();
        $controller = $request->attributes->get('_controller');
        preg_match('/(.*)Bundle\\\Controller\\\(.*)Controller::(.*)Action/', $controller, $matches);
        
        return $matches ;
    }
}
