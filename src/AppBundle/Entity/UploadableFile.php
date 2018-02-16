<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="uploaded_file")
 * @Gedmo\Uploadable(maxSize=50000000, allowedTypes="image/png,application/zip,image/jpg,image/jpeg", allowOverwrite=false, appendNumber=true)
 * @Gedmo\Loggable
 */
class UploadableFile
{
    /*
     * @Assert\File(maxSize="60000000")
     */
    private $file;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="path", type="string")
     * @Gedmo\UploadableFilePath
     * 
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true )
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(name="mime_type", type="string")
     * @Gedmo\UploadableFileMimeType
     * @Assert\NotBlank
     */
    private $mimeType;

    /**
     * @ORM\Column(name="size", type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="created_by", type="string", nullable=true)
     * @Gedmo\Blameable(on="create")
     */
    private $createdBy;

    /**
     * @var string
     *
     * @ORM\Column(name="updated_by", type="string", nullable=true)
     * @Gedmo\Blameable(on="update")
     */
    private $updatedBy;

    public function getId()
    {
            return $this->id;
    }

    public function getPath()
    {
            return $this->path;
    }

    public function getMimeType()
    {
            return $this->mimeType;
    }

    public function getSize()
    {
            return $this->size;
    }

    /**
     * Get URL of file
     *
     * @return string
     */
    public function getURL()
    {
            return $this->path === null ? null : '/' . $this->getPath();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
            return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
            return $this->updatedAt;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
            return $this->createdBy;
    }

    /**
     * Get updatedBy
     *
     * @return string
     */
    public function getUpdatedBy()
    {
            return $this->updatedBy;
    }

    public function __toString()
    {
            return basename($this->path);
    }

    /**
     * Set path
     *
     * @param string $path
     * @return UploadableFile
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return UploadableFile
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    
        return $this;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return UploadableFile
     */
    public function setSize($size)
    {
        $this->size = $size;
    
        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UploadableFile
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return UploadableFile
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     * @return UploadableFile
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    
        return $this;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     * @return UploadableFile
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    
        return $this;
    }
    
    
    public function upload() {
        
        error_log("File->upload -> init ");
        
        if(is_null($this->file)) 
        {
            error_log("File->upload -> is null ");
            return false ;
        }
 
        error_log("File->upload -> not null ");

        $this->path = $this->file->getClientOriginalName();
        $extension = preg_replace('#^.*(\.[a-z0-9]+)$#', '$1', $this->path);
        $this->path = str_replace($extension,time().$extension, $this->path);
        $this->name = $this->path;
        
        error_log("File->upload -> ".$this->name);
        
        if($this->makeDir())
        {
            $this->file->move($this->getUploadRootDir(), $this->name);
        
            if ($this->type === 'picture') 
            {
                error_log("File->upload -> picture ");

                if(file_exists($this->getUploadRootDir().'/'.$this->name))
                {
                    $origin = new Image($this->getUploadRootDir().'/'.$this->name);

                    if($this->makeDir("/big/"))
                    {
                        $Big = clone $origin ; //new Image($this->getUploadRootDir().'/'.$this->name);
                        $Big->resize(800, 800);
                        $Big->create($this->getUploadRootDir().'/big/'.$this->name, 100);
                    }

                    if($this->makeDir("/medium/"))
                    {
                        $Medium = clone $origin ; //new Image($this->getUploadRootDir().'/'.$this->name);
                        $Medium->resize(500, 500);
                        $Medium->create($this->getUploadRootDir().'/medium/'.$this->name, 100);
                    }

                    if($this->makeDir("/small/"))
                    {
                        $Small = clone $origin ; //new Image($this->getUploadRootDir().'/'.$this->name);
                        $Small->resize(200, 200);
                        $Small->create($this->getUploadRootDir().'/small/'.$this->name, 100);
                    }

                    if($this->makeDir("/vignette/"))
                    {
                        $Vignette = clone $origin ; //new Image($this->getUploadRootDir().'/'.$this->name);
                        $Vignette->resize(75, 75);
                        $Vignette->create($this->getUploadRootDir().'/vignette/'.$this->name, 100);
                    }
                }
                else 
                {
                    error_log("original image does'nt exist...");
                }
            }
            
            error_log("File->upload ->test ". $this->getUploadRootDir().'/'.$this->name );

            if(file_exists($this->getUploadRootDir().'/'.$this->name))
            {
                return true ;
            }
            else 
            {
                error_log("File->upload -> file does'nt exist...");
            }
        }
        return false ;
        
      /**  
        error_log("File->upload -> clear ");
        
        $this->file = null;**/
    }
    
    
    function __construct() {
        
        error_log("Cetelem/entity/file(".$this->getId().")->construct()");
        $this->file = null ;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->name ? null : $this->getUploadRootDir().'/'.$this->name;
    }

    public function confirmWebPath($type = '')
    {
        if ($type == '') {
            $folder = '/';
        } else {
            $folder = "/$type/";
        }
        
        $uploadRootDir = $this->getUploadRootDir();
        $uploadRootDir = str_replace("\\", "/", $uploadRootDir);
        
        $final_path = $uploadRootDir.$folder.$this->name ;
        $final_path = str_replace("//", "/", $final_path);
        
        error_log("file->confirmWebPath::".$final_path);
        
        if(file_exists($final_path))
            return true ;

        //if(file_exists($this->getAbsolutePath()))
        //    return true ;

        return false ;
    }
    
    public function getWebPath($type = '')
    {
        if ($type == '') {
            $folder = '/';
        } else {
            $folder = "/$type/";
        }
        
        $uploadDir = $this->getUploadDir();
        $uploadDir = str_replace("\\", "/", $uploadDir);
        
        $final_path = $uploadDir.$folder.$this->name ;
        $final_path = str_replace("//", "/", $final_path);
        
        error_log("file->getWebPath::".'/'.$final_path);
        
        if($this->confirmWebPath($type))
            return null === $this->name ? null : '/'.$final_path;
        
        return null ;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        $uploadRootDir = realpath(__DIR__.'/../../../web').'/'.$this->getUploadDir();
        $uploadRootDir = str_replace("\\", "/", $uploadRootDir);
       
        error_log("file->getUploadRootDir::".$uploadRootDir);
        
        return $uploadRootDir;
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        $uploadDir = 'uploads/'.$this->type."/";
        
        error_log("file->getUploadDir::".$uploadDir);
        
        return $uploadDir;
    }
    

    private function makeDir($dir = "/")
    {
        error_log("file->makeDir...");
        
        if(!file_exists($this->getUploadRootDir()) || !is_dir($this->getUploadRootDir()))
        {
            if(!mkdir($this->getUploadRootDir(),0777,true))
            {
                return false;
            }
            else
            {
                error_log($this->getUploadRootDir()." a été créé ...");
            }
        }
        else
        {
            error_log($this->getUploadRootDir()." existe et est bien un répertoire");
            if(is_writable($this->getUploadRootDir()))
            {
                if(!chmod($this->getUploadRootDir(), 0777))
                {
                    return false ;
                }
                else
                {
                    error_log($this->getUploadRootDir()." a été ouvert à l'ecriture ...");
                }
            }
            else
            {
                error_log($this->getUploadRootDir()." est ouvert en ecriture");
            }
                
        }
        
        if(file_exists($this->getUploadRootDir()))
        {
            if(is_writable($this->getUploadRootDir()))
            {
                $realpath = ($this->getUploadRootDir().$dir);
                
                if(!file_exists($realpath) || !is_dir($realpath))
                {
                    if(!mkdir($realpath,0777,true))
                    {
                           return false;
                    }
                    else
                    {
                        error_log("'$dir' a été créé ...");
                    }
                }
                else
                {
                    error_log("'$dir' existe et est bien un répertoire");
                }
                
                if(!is_writable($realpath))
                {
                    if(!chmod($realpath, 0777))
                    {
                            return false ;
                    }
                    else
                    {
                        error_log("'$dir' a été ouvert à l'ecriture ...");
                    }
                }
                else
                {
                    error_log("'$dir' est ouvert en ecriture");
                }
                return true;
            }
            
        }
        
        return false;
    }
    
}