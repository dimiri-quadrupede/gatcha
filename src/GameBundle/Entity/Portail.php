<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;

use GameBundle\Entity\Personnage;
use GameBundle\Entity\PortailBox;

/**
 * Portail
 *
 * @ORM\Table(name="portail")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\PortailRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 */
class Portail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="date", name="started_at", nullable=true)
     */
    private $startedAt;   
    
    /**
     * @ORM\Column(type="date", name="ended_at", nullable=true)
     */
    private $endedAt; 
    
    /**
     * One Portail has Many PortailBox.
     * @ORM\OneToMany(targetEntity="PortailBox", mappedBy="portail",cascade={"persist"})
     */
    private $portailBoxes ;
    
    /**
     * Owning Side -- 
     * 
     * Many Portail have Many Personnage.
     * @--ORM--\--ManyToMany(targetEntity="Personnage", inversedBy="PortailBoxes")
     * @--ORM--\--JoinTable( name="portail_box", 
     *      joinColumns={@--ORM--\--JoinColumn(name="portail_id", referencedColumnName="id")},
     *      inverseJoinColumns={@--ORM--\--JoinColumn(name="personnage_id", referencedColumnName="id")}
     *      )
    private $personnages ; 
         */   
    
    
     /**
     * @Gedmo\Slug(fields={"name", "id"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

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
     * @var string $createdBy
     *
     * @ORM\Column(name="created_by", type="string")
     * @Gedmo\Blameable(on="create")
     */
    private $createdBy;

    /**
     * @var string $updatedBy
     *
     * @ORM\Column(name="updated_by", type="string")
     * @Gedmo\Blameable(on="update")
     */
    private $updatedBy;

    /**
     * @var \DateTime $deletedAt
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

   
    public function __construct() 
    {
        $this->portailBoxes = new ArrayCollection();
    }

    public function __toString() {
        return $this->getName();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Portail
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id ;
        
        return $this ;
    }
    /**
     * Add portailBox
     *
     * @param \GameBundle\Entity\PortailBox $portailBox
     *
     * @return Portail
     */
    public function addPortailBox(PortailBox $portailBox)
    {
        $this->portailBoxes[] = $portailBox;

        return $this;
    }

    /**
     * Remove portailBox
     *
     * @param \GameBundle\Entity\PortailBox $portailBox
     */
    public function removePortailBox(PortailBox $portailBox)
    {
        $this->portailBoxes->removeElement($portailBox);
    }

    /**
     * Get portailBoxes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPortailBoxes()
    {
        return $this->portailBoxes;
    }

    /**
     * Add personnage
     *
     * @param \GameBundle\Entity\Personnage $personnage
     *
     * @return Portail
     */
    public function addPersonnage(Personnage $personnage)
    {   
        $p = new PortailBox();
        $p->setPersonnage($personnage);
        $p->setPortail($this);
        
        $this->addPortailBox($p);
        
        //$this->personnages[] = $personnage;

        return $this;
    }

    /**
     * Remove personnage
     *
     * @param \GameBundle\Entity\Personnage $personnage
     */
    public function removePersonnage(Personnage $personnage)
    {
        foreach($this->portailBoxes as $p)
        {
            if($p->getPersonnage()===$personnage)
            {
                $this->removePortailBox($p);
            }
        }
        
        //$this->personnages->removeElement($personnage);
    }

    /**
     * Get personnages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnages()
    {
        $persos = array();
        
        foreach($this->portailBoxes as $p)
            $persos[] = $p->getPersonnage();
        
        return $persos ;
        //return $this->personnages;
    }

    /**
     * Set startedAt
     *
     * @param \DateTime $startedAt
     *
     * @return Portail
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * Get startedAt
     *
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set endedAt
     *
     * @param \DateTime $endedAt
     *
     * @return Portail
     */
    public function setEndedAt($endedAt)
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    /**
     * Get endedAt
     *
     * @return \DateTime
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Portail
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Portail
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Portail
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
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
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return Portail
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
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
     * Set updatedBy
     *
     * @param string $updatedBy
     *
     * @return Portail
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
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

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Portail
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
