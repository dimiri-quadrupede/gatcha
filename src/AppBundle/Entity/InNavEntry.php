<?php

namespace AppBundle\Entity ;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * InNavEntry
 *
 * @ORM\Table(name="in_nav_entry")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InNavEntryRepository")
  * @Gedmo\Loggable
*/
class InNavEntry
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *  nameUser mémorisé en cas de suppression
     * @var string $nameUser
     *
     * @ORM\Column(name="name_user", type="string", length=255, nullable=true)
     */
    private $nameUser;
    
/**
	 * @var string $uri
	 *
	 * @ORM\Column(name="uri", type="string", length=500, nullable=true)
	 * @Gedmo\Versioned
	 */
	private $uri;
        
   /**
    * @var \DateTime $createdAt
    *
    * @ORM\Column(name="created_at", type="datetime", nullable=true)
    * @Gedmo\Timestampable(on="create")
    */
   private $createdAt;

   /**
    * @var \DateTime $updatedAt
    *
    * @ORM\Column(name="updated_at", type="datetime", nullable=true)
    * @Gedmo\Timestampable(on="update")
    */
   private $updatedAt;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
    * Set nameUser
    *
    * @param text $nameUser
    */
   public function setNameUser( $nameUser )
   {
           $this->nameUser = $nameUser;

           return $this;
   }

   /**
    * Get nameUser
    *
    * @return text
    */
   public function getNameUser()
   {
           return $this->nameUser;
   }
   
   /**
    * Set uri
    *
    * @param string $uri
    */
   public function setUri( $uri )
   {
           $this->uri = $uri;
   }

   /**
    * Get uri
    *
    * @return string
    */
   public function getUri()
   {
           return $this->uri;
   }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return InNavEntry
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
     * @return InNavEntry
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }
}
