<?php
namespace GameBundle\Controller ;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use GameBundle\Entity\Portail;
use GameBundle\Entity\PortailInvoc;
use GameBundle\Entity\PlayerBox;
use GameBundle\Entity\Personnage;
use GameBundle\Entity\PersonnageInvoc;

/**
 * Description of InvocationController
 *
 * @Route("invocation")
 * @author lmq-dimitri
 */
class InvocationController extends Controller {
    //put your code here
    
    /**
     * @Route("/", name="invocation_portail_list")
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $portails = $em->getRepository("GameBundle:Portail")->findOpened() ;
        
        return $this->render('GameBundle:Invocation:index.html.twig', array(
            'portails' => $portails,
        ));
        
    }
    
    /**
     * Finds and displays a portail entity.
     *
     * @Route("/{id}/show", name="invocation_portail_show")
     * @Method("GET")
     */
    public function showAction(Portail $portail)
    {
        return $this->render('GameBundle:Invocation:show.html.twig', array(
            'portail' => $portail,
        ));
    }
    
    /**
     * 
     * @param Portail $portail
     * @param PortailInvoc $invoc
     */
    private function makeInvoc(Portail $portail = null , $multi = false , PortailInvoc $invoc = null)
    {
        error_log("makeInvoc -> launch");
        
        $em = $this->getDoctrine()->getManager();
        
        error_log("makeInvoc -> em");
        
        if(is_null($invoc) && !is_null($portail))
        {
            error_log("makeInvoc -> null invoc ");
            
            $invoc = new PortailInvoc();
            $invoc->setPortail($portail);
            $invoc->setPlayer($this->getUser());
            $invoc->setMulti($multi);
        }
        
        error_log("makeInvoc -> invoc record ");
        $em->persist($invoc);
        $em->flush();

        $droped = count($invoc->getPersonnages());
        
        error_log("makeInvoc -> invoc droped : $droped ");

        if($droped <= 5)
        {
            $personnage = $em->getRepository("GameBundle:Personnage")->findRandom($portail) ;
            
            error_log("makeInvoc -> random perso : $personnage ");
            
            $drop = new PlayerBox();
            $drop->setPlayer($this->getUser());
            $drop->setPersonnage($personnage);
            $drop->setVie($personnage->getVie());
            $drop->setExperience(0);

            error_log("makeInvoc -> random perso : drop ");
            
            $em->persist($drop);
            $em->flush();
            
            error_log("makeInvoc -> drop record ");
            
            $call = new PersonnageInvoc();
            $call->setPersonnage($personnage);
            $call->setInvocation($invoc);

            error_log("makeInvoc -> random perso : call ");
            
            $em->persist($call);
            $em->flush();
            
            error_log("makeInvoc -> call record ");
            
            return array( $invoc , $personnage );
        }
        
        return array( $invoc , null );
    }
    
    /**
     * @Route("/{id}/many", name="invocation_portail_many")
     * @Route("/{id}/mono", name="invocation_portail_mono")
     * @param Portail $portail
     * @return type
     */
    public function firstAction(Request $request , Portail $portail)
    {
        $routeName = $request->get('_route');        
        
        $multi = $routeName === "invocation_portail_many" ? true  : ( $routeName === "invocation_portail_mono" ? false : false ) ;
        
        error_log( "firstAction route : $routeName => multi = $multi ");
        
        list( $invoc , $personnage ) = $this->makeInvoc($portail, $multi );
        
        return $this->render('GameBundle:Invocation:result.html.twig', array(
            'portail' => $portail,
            'personnage' => $personnage,
            'invocation' => $invoc
        ));
    }
    
    /**
     * @Route("/{id}/multi", name="invocation_portail_multi")
     * @param Portail $portail
     * @return type
     */
    public function multiAction(Request $request , PortailInvoc $invoc = null)
    {        
        $portail = $invoc->getPortail();
        
        list( $invoc , $personnage ) = $this->makeInvoc($portail, true , $invoc);
        
        return $this->render('GameBundle:Invocation:result.html.twig', array(
            'portail' => $portail,
            'personnage' => $personnage,
            'invocation' => $invoc
        ));
    }
    
    /**
     * @Route("/{id}/end", name="invocation_portail_end")
     * @param Portail $portail
     * @return type
     */
    public function endAction(Request $request , PortailInvoc $invoc = null)
    {        
        $portail = $invoc->getPortail();
        
        $personnages = $invoc->getPersonnages();
        
        return $this->render('GameBundle:Invocation:end.html.twig', array(
            'portail' => $portail,
            'invocation' => $invoc,
            'personnages' =>$personnages
        ));
    }
    
}
