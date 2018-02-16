<?php

namespace AdminBundle\Controller;

use GameBundle\Entity\Rarete;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Rarete controller.
 *
 * @Route("rarete")
 */
class RareteController extends Controller
{
    /**
     * Lists all rarete entities.
     *
     * @Secure(roles="ROLE_ADMIN_RARETE_LIST")
     * @Route("/", name="rarete_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $raretes = $em->getRepository('GameBundle:Rarete')->findAll();

        foreach($raretes as $x => $rarete)
            $deleteForm[$x] = $this->createDeleteForm($rarete)->createView();
        
        return $this->render('AdminBundle:Rarete:index.html.twig', array(
            'raretes' => $raretes,
            'delete_form' => $deleteForm
        ));
    }

    /**
     * Creates a new rarete entity.
     * Displays a form to edit an existing rarete entity.
     *
     * @Secure(roles="ROLE_ADMIN_RARETE_EDIT")
     * @Route("/new", name="rarete_new")
     * @Route("/{id}/edit", name="rarete_edit")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Rarete $rarete = null )
    {
        if(is_null($request))
            $request = $this->get('request');
        
        if(is_null($rarete))
        {
            $rarete = new Rarete();
        }
        else 
        {
            $deleteForm = $this->createDeleteForm($rarete);
        }
        
        $form = $this->createForm('GameBundle\Form\RareteType', $rarete);
        
        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) 
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($rarete);
                $em->flush();

                return $this->redirectToRoute('rarete_edit', array('id' => $rarete->getId()));
            }
        }
        
        return $this->render('AdminBundle:Rarete:new.html.twig', array(
            'rarete' => $rarete,
            'form' => $form->createView(),
            'delete_form' => isset($deleteForm) ? $deleteForm->createView() : null ,
        ));
    }

    /**
     * Deletes a rarete entity.
     *
     * @Secure(roles="ROLE_ADMIN_RARETE_DEL")
     * @Route("/{id}/delete", name="rarete_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rarete $rarete)
    {
        $form = $this->createDeleteForm($rarete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rarete);
            $em->flush();
        }

        return $this->redirectToRoute('rarete_index');
    }

    /**
     * Creates a form to delete a rarete entity.
     *
     * @param Rarete $rarete The rarete entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rarete $rarete)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rarete_delete', array('id' => $rarete->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
