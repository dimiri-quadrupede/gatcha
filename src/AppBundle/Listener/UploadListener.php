<?php
namespace AppBundle\Listener;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\UploadableFile;
use AppBundle\Service\FileUploader;

/**
 * Description of UploadListener
 *
 * @author lmq-dimitri
 */
class UploadListener {
    
    //put your code here
    private $uploader;

    /**
     * 
     * @param FileUploader $uploader
     */
    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * 
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    /**
     * 
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    /**
     * 
     * @param UploadableFile $entity
     * @return type
     */
    private function uploadFile(UploadableFile $entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof UploadableFile) {
            return;
        }

        $file = $entity->getFile();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setFile($fileName);
        }
    }
 
    /**
     * 
     * @param LifecycleEventArgs $args
     * @return type
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof UploadableFile) {
            return;
        }

        if ($fileName = $entity->getFile()) {
            $entity->setFile(new File($this->uploader->getTargetDir().'/'.$fileName));
        }
    }
}
