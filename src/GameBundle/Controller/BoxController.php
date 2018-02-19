<?php
namespace GameBundle\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Controller\BaseController;
use GameBundle\Entity\PlayerBox;
use GameBundle\GameBundle;
use GameBundle\Entity\PlayerEquipe;
use AppBundle\Entity\Player;
/**
 * Description of BoxController
 *
 * @Route("box")
 * @author lmq-dimitri
 */
class BoxController extends BaseController {
    //put your code here
    
    /**
     * @Route("/", name="player_box_list")
     * @Route("/{function}/list", name="player_box_function")
     * 
     * @param Request $request
     */
    public function indexAction(Request $request, $function = null )
    {
        //die(print_r($this->getRequestPath($request),1));
 
       $em = $this->getDoctrine()->getManager();
        
        $boxes = $em->getRepository("GameBundle:PlayerBox")->findBy(array(
            "player" => $this->getUser()
        )) ;
        
        return $this->render('GameBundle:Box:index.html.twig', array(
            'boxes' => $boxes,
            'function' => $function,
                
        ));
        
    }
    
   /**
    *  @Route("/{id}/train", name="player_box_train")
	**/
    public function trainningAction(Request $request )
    {
       $em = $this->getDoctrine()->getManager();
        
        $boxes = $em->getRepository("GameBundle:PlayerBox")->findBy(array(
            "player" => $this->getUser()
        )) ;
        
        return $this->render('GameBundle:Box:index.html.twig', array(
            'boxes' => $boxes,
            'function' => "check",
                
        ));
    }
}
