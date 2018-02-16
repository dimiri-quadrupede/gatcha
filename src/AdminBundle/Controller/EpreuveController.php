<?php

namespace AdminBundle\Controller;

use GameBundle\Entity\Epreuve;
use GameBundle\Entity\Zone;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Epreuve controller.
 *
 * @Route("epreuve")
 */
class EpreuveController extends Controller
{
    /**
     * Lists all epreuve entities.
     *
     * @Route("/", name="epreuve_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $epreuves = $em->getRepository('GameBundle:Epreuve')->findAll();

        return $this->render('AdminBundle:Epreuve:index.html.twig', array(
            'epreuves' => $epreuves,
        ));
    }

    /**
     * Finds and displays a epreuve entity.
     *
     * @Route("/{id}/show", name="epreuve_show")
     * @Method("GET")
     */
    public function showAction(Epreuve $epreuve)
    {
        $deleteForm = $this->createDeleteForm($epreuve);

        return $this->render('AdminBundle:Epreuve:show.html.twig', array(
            'epreuve' => $epreuve,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Displays a form to edit an existing epreuve entity.
     *
     * @Route("/{zone}/add", name="epreuve_add")
     * @Method({"GET", "POST"})
     */
    
    public function addAction(Request $request, Zone $zone = null )
    {
        if(is_null($request))
            $request = $this->getRequest();
        
        $epreuve = new Epreuve();
        
        $epreuve->setZone($zone);
        
        $editForm = $this->createForm('GameBundle\Form\EpreuveType', $epreuve);
        
        if($request->isMethod("post"))
        {
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($epreuve);
                $em->flush();

                return $this->redirectToRoute('zone_edit', array('id' => $zone->getId()));
            }
        }
        
        return $this->render('AdminBundle:Epreuve:edit.html.twig', array(
            'epreuve' => $epreuve,
            'edit_form' => $editForm->createView(),
            'delete_form' => is_null($epreuve->getId()) ? null : $deleteForm->createView(),
            'zone' => $zone
        ));
    }   
    
    /**
     * Displays a form to edit an existing epreuve entity.
     *
     * @Route("/new", name="epreuve_new")
     * @Route("/{id}/edit", name="epreuve_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Epreuve $epreuve = null  )
    {
        if(is_null($request))
            $request = $this->getRequest();
               
        if(is_null($epreuve))
        {
            $epreuve = new Epreuve();
        }
        else
        {
            $deleteForm = $this->createDeleteForm($epreuve);
            $zone = $epreuve->getZone();
        }
        
        
        $editForm = $this->createForm('GameBundle\Form\EpreuveType', $epreuve);
        
        if($request->isMethod("post"))
        {
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($epreuve);
                $em->flush();

                return $this->redirectToRoute('epreuve_edit', array('id' => $epreuve->getId()));
            }
        }
        
        return $this->render('AdminBundle:Epreuve:edit.html.twig', array(
            'epreuve' => $epreuve,
            'edit_form' => $editForm->createView(),
            'delete_form' => is_null($epreuve->getId()) ? null : $deleteForm->createView(),
            'zone' => $zone
        ));
    }

    /**
     * Deletes a epreuve entity.
     *
     * @Route("/{id}", name="epreuve_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Epreuve $epreuve)
    {
        $form = $this->createDeleteForm($epreuve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($epreuve);
            $em->flush();
        }

        return $this->redirectToRoute('epreuve_index');
    }

    /**
     * Creates a form to delete a epreuve entity.
     *
     * @param Epreuve $epreuve The epreuve entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Epreuve $epreuve)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('epreuve_delete', array('id' => $epreuve->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
