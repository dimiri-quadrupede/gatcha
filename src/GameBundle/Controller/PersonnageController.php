<?php
namespace GameBundle\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use GameBundle\Entity\Personnage;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Description of PersonnageController
 * 
 * @Route("carte")
 * @author lmq-dimitri
 */
class PersonnageController extends Controller {
    
    /**
     * Finds and displays a personnage entity.
     *
     * @Secure(roles="ROLE_PERSONNAGE_SHOW")
     * @Route("/{slug}/show", name="game_personnage_show")
     * @Method("GET")
     */
    public function showAction(Personnage $personnage)
    {
        //$deleteForm = $this->createDeleteForm($personnage);

        return $this->render('GameBundle:Personnage:show.html.twig', array(
            'personnage' => $personnage,
            //'delete_form' => $deleteForm->createView(),
        ));
    }
}
