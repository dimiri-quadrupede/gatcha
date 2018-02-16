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

use GameBundle\Entity\PlayerBox;
use GameBundle\GameBundle;
use GameBundle\Entity\PlayerEquipe;
use AppBundle\Entity\Player;

/**
 * Description of TeamController
 * @Route("team")
 * @author lmq-dimitri
 */
class TeamController extends Controller {
    //put your code here
    
 /**
     * @Route("/", name="player_equipes")
     * @param Request $request
     * @return type
     */
    public function indexAction(Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        
        $equipes = $em->getRepository("GameBundle:PlayerEquipe")->findBy(array(
            "player" => $this->getUser()
        )) ;//->findBox($this->getUser()) ;
        
        $teams = array();
        
        foreach ($equipes as $equipe)
            $teams[$equipe->getRanked()] = $equipe ;
        
        return $this->render('GameBundle:Team:index.html.twig', array(
            'teams' => $teams,
            'max_team' => GameBundle::$max_team
        ));
    }
    
    private function getTeam(Player $player , $ranked = 1 )
    {
        $em = $this->getDoctrine()->getManager();
        
        $eq = $em->getRepository("GameBundle:PlayerEquipe")->findOneBy(array(
            "player" => $player , "ranked" => $ranked
        )) ;
        
        if(is_null($eq))
        {
            $eq = new PlayerEquipe();
            $eq->setRanked($ranked);
            $eq->setPlayer($this->getUser());
            
            $em->persist($eq);
            $em->flush();
        }
        
        return $eq ;
    }
    
    /**
     * @Route("/{ranked}/show", name="player_team")
     * @param Request $request
     * @param type $ranked
     * @return type
     */
    public function teamAction(Request $request , $ranked = 1 )
    {
        $equipe = $this->getTeam($this->getUser(),$ranked);
        
        $em = $this->getDoctrine()->getManager();
       
        $eqs = $em->getRepository("GameBundle:PlayerBox")->findBy(array(
            "player" => $this->getUser() , "equipe" => $equipe
        )) ;
        
         $membs = array();
        
        foreach ($eqs as $equipe)
            $membs[$equipe->getRanked()] = $equipe ;
        
        
        return $this->render('GameBundle:Team:show.html.twig', array(
            'team' => $equipe ,
            'members' => $membs ,
            'max_team' => GameBundle::$max_team_in
        ));
    }
    
    /**
     * @Route("/{ranked}/team/{poste}/select", name="player_team_select")
     * 
     * @param Request $request
     */
    public function teamSelectAction(Request $request, $ranked = null , $poste = null )
    {
        $equipe = $this->getTeam($this->getUser(),$ranked);
        
        $em = $this->getDoctrine()->getManager();
        
        $boxes = $em->getRepository("GameBundle:PlayerBox")->findBy(array(
            "player" => $this->getUser()
        )) ;
        
        return $this->render('GameBundle:Box:index.html.twig', array(
            'team' => $equipe ,
            'boxes' => $boxes,
            'team' => $equipe ,
            'function' => "select",
            'poste' => $poste ,
            'ranked' =>$ranked ,
                
        ));
        
    }    
    
    /**
     * @Route("/{id}/add-in/{ranked}/team/{poste}", name="player_team_add")
     * @param Request $request
     * @param PlayerBox $box
     * @param type $ranked
     * @param type $poste
     */
    public function addInTeamAction(Request $request, PlayerBox $box , $ranked = null , $poste = null )
    {
        $equipe = $this->getTeam($this->getUser(),$ranked);
        
        //$equipe->addAffect($box);
        $box->setEquipe($equipe);
        
        $em = $this->getDoctrine()->getManager();
        
        $em->persist($box);
        $em->flush();
        
        $eqs = $em->getRepository("GameBundle:PlayerBox")->findBy(array(
            "player" => $this->getUser() , "equipe" => $equipe
        )) ;
        
         $membs = array();
        
        foreach ($eqs as $equipe)
            $membs[$equipe->getRanked()] = $equipe ;
        
        
        return $this->render('GameBundle:Team:show.html.twig', array(
            'team' => $equipe ,
            'members' => $membs ,
            'max_team' => GameBundle::$max_team_in,
            'poste' => $poste ,
            'ranked' =>$ranked ,
        ));

    }
}
