<?php

namespace AdminBundle\Controller;

use GameBundle\Entity\Personnage;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use AppBundle\Controller\BaseController;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\UploadableFile;

use AppBundle\Service\FileUploader;

use Doctrine\ORM\EntityManager ;
/**
 * Personnage controller.
 *
 * @Route("personnage")
 */
class PersonnageController extends BaseController
{
   
    /**
     * Lists all personnage entities.
     * @Secure(roles="ROLE_ADMIN_PERSONNAGE_LIST")
     * @Route("/", name="personnage_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $personnages = $em->getRepository('GameBundle:Personnage')->findAll();

        foreach($personnages as $x => $personnage)
            $deleteForm[$x] = $this->createDeleteForm($personnage)->createView();
        
        return $this->render('AdminBundle:Personnage:index.html.twig', array(
            'personnages' => $personnages,
            'delete_form' => $deleteForm
        ));
    }  
    
     /**
     * Creates a new personnage entity.
     *
     * @Secure(roles="ROLE_ADMIN_PERSONNAGE_EDIT")
     * @Route("/new", name="personnage_new")
     * @Route("/{slug}/edit", name="personnage_edit")
     * @Method({"GET","POST"})
     * @Template()
      * 
      *  FileUploader $fileUploader,
     */
    public function editionAction(Request $request = null, Personnage $personnage = null)
    {
        if(is_null($request))
            $request = $this->get('request');
                
        if(is_null($personnage))
        {
            $personnage = new Personnage();
        }
        else
        {
            $deleteForm = $this->createDeleteForm($personnage);
        }
        
        $form = $this->createForm('GameBundle\Form\PersonnageType', $personnage);
        
        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) 
            {
                $em = $this->getDoctrine()->getManager();
                
                $icon = $personnage->getIcon() ;
                $card = $personnage->getCard() ;
                
                $this->saveImg($em, $icon);
                $this->saveImg($em, $card);
                

                
                $em->persist($personnage);
                $em->flush();

                return $this->redirectToRoute('personnage_edit', array('slug' => $personnage->getSlug()));
            }
        }
        
        return $this->render('AdminBundle:Personnage:edit.html.twig', array(
            'personnage' => $personnage,
            'form' => $form->createView(),
            'delete_form' => is_null($personnage->getId()) ? null : $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a personnage entity.
     *
     * @Secure(roles="ROLE_ADMIN_PERSONNAGE_DEL")
     * @Route("/{id}/delete", name="personnage_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Personnage $personnage)
    {
        $form = $this->createDeleteForm($personnage);
        
        if($request->isMethod("post"))
        {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($personnage);
                $em->flush();
            }
        }
        return $this->redirectToRoute('personnage_index');
    }

    /**
     * Creates a form to delete a personnage entity.
     *
     * @param Personnage $personnage The personnage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Personnage $personnage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('personnage_delete', array('id' => $personnage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
