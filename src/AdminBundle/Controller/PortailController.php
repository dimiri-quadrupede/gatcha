<?php

namespace AdminBundle\Controller;

use GameBundle\Entity\Portail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

/**
 * Portail controller.
 *
 * @Route("portail")
 */
class PortailController extends Controller
{
    /**
     * Lists all portail entities.
     *
     * @Route("/", name="portail_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $portails = $em->getRepository('GameBundle:Portail')->findBy(array(
            'deletedAt' => null
        ));

        foreach($portails as $x => $portail)
            $deleteForm[$x] = $this->createDeleteForm($portail)->createView();
        
        return $this->render('AdminBundle:Portail:index.html.twig', array(
            'portails' => $portails,
            'delete_form' => $deleteForm
        ));
    }

    /**
     * Displays a form to edit an existing portail entity.
     *
     * @Route("/new", name="portail_new")
     * @Route("/{id}/edit", name="portail_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Portail $portail = null )
    {
        if(is_null($portail))
        {
            $portail = new Portail();
        }
        else
        {
            $deleteForm = $this->createDeleteForm($portail);
        }
        $editForm = $this->createForm('GameBundle\Form\PortailType', $portail);
        
        if($request->isMethod("post"))
        {
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) 
            {
                //$this->getDoctrine()->getManager()->flush();
                $em = $this->getDoctrine()->getManager();
                $em->persist($portail);
                $em->flush();
                
                return $this->redirectToRoute('portail_edit', array('id' => $portail->getId()));
            }
        }
        
        return $this->render('AdminBundle:Portail:edit.html.twig', array(
            'portail' => $portail,
            'edit_form' => $editForm->createView(),
            'delete_form' => is_null($portail->getId()) ? null : $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a portail entity.
     *
     * @Route("/{id}/delete", name="portail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Portail $portail)
    {
        $form = $this->createDeleteForm($portail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($portail);
            $em->flush();
        }

        return $this->redirectToRoute('portail_index');
    }

    /**
     * Creates a form to delete a portail entity.
     *
     * @param Portail $portail The portail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Portail $portail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('portail_delete', array('id' => $portail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
