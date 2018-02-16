<?php

namespace AdminBundle\Controller;

use GameBundle\Entity\Zone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Zone controller.
 *
 * @Route("zone")
 */
class ZoneController extends Controller
{
    /**
     * Lists all zone entities.
     *
     * @Route("/", name="zone_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $zones = $em->getRepository('GameBundle:Zone')->findAll();

        return $this->render('AdminBundle:Zone:index.html.twig', array(
            'zones' => $zones,
        ));
    }

    /**
     * Finds and displays a zone entity.
     *
     * @Route("/{id}/show", name="zone_show")
     * @Method("GET")
     */
    public function showAction(Zone $zone)
    {
        $deleteForm = $this->createDeleteForm($zone);

        return $this->render('AdminBundle:Zone:show.html.twig', array(
            'zone' => $zone,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing zone entity.
     *
     * @Route("/new", name="zone_new")
     * @Route("/{id}/edit", name="zone_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Zone $zone = null )
    {
        if(is_null($zone))
        {
            $zone = new Zone();
        }
        else
        {
            $deleteForm = $this->createDeleteForm($zone);
        }
        
        $editForm = $this->createForm('GameBundle\Form\ZoneType', $zone);
        
        if($request->isMethod("post"))
        {
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($zone);
                $em->flush();

                return $this->redirectToRoute('zone_edit', array('id' => $zone->getId()));
            }
        }
        
        return $this->render('AdminBundle:Zone:edit.html.twig', array(
            'zone' => $zone,
            'edit_form' => $editForm->createView(),
            'delete_form' => is_null($zone->getId()) ? null : $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a zone entity.
     *
     * @Route("/{id}/delete", name="zone_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Zone $zone)
    {
        $form = $this->createDeleteForm($zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($zone);
            $em->flush();
        }

        return $this->redirectToRoute('zone_index');
    }

    /**
     * Creates a form to delete a zone entity.
     *
     * @param Zone $zone The zone entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Zone $zone)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zone_delete', array('id' => $zone->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
