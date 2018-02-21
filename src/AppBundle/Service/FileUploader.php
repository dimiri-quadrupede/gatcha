<?php
namespace AppBundle\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of FileUploader
 *
 * @author lmq-dimitri
 */
class FileUploader {
    //put your code here
    private $targetDir;

    /**
     * 
     * @param type $targetDir
     */
    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    /**
     * 
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    /**
     * 
     * @return type
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }
}
