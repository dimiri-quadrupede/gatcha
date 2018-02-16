<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;

use AppBundle\Entity\Player;
use GameBundle\Entity\Portail;
use GameBundle\Entity\PersonnageInvoc;
/**
 * PortailInvoc
 *
 * @ORM\Table(name="portail_invoc", indexes={@ORM\Index(name="player_invoc_FKIndex1", columns={"portail_id"}), @ORM\Index(name="player_invoc_FKIndex2", columns={"player_id"})})
 * @ORM\Entity
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 */
class PortailInvoc
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
     * @var \AppBundle\Entity\Player
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    private $player;

    /**
     * @var \AppBundle\Entity\Portail
     *
     * @ORM\ManyToOne(targetEntity="Portail")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="portail_id", referencedColumnName="id")
     * })
     */
    private $portail;

    /**
     *
     * @ORM\Column(name="multi", type="boolean", nullable=true,options={"default":true})
     */
    private $multi = false ;
    
    /**
     *
     * @ORM\Column(name="droped", type="integer", length=4, nullable=true,options={"default":1})
     */
    private $droped = 1 ;
    
    /**
     * One PortailInvoc has Many PersonnageInvoc.
     * @ORM\OneToMany(targetEntity="PersonnageInvoc", mappedBy="invocation",cascade={"persist"})
     */
    private $personnageInvocs ;
 
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
     * Set player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return PortailInvoc
     */
    public function setPlayer(Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \AppBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set portail
     *
     * @param \AppBundle\Entity\Portail $portail
     *
     * @return PortailInvoc
     */
    public function setPortail(Portail $portail = null)
    {
        $this->portail = $portail;

        return $this;
    }

    /**
     * Get portail
     *
     * @return \AppBundle\Entity\Portail
     */
    public function getPortail()
    {
        return $this->portail;
    }

    /**
     * Set multi
     *
     * @param boolean $multi
     *
     * @return PortailInvoc
     */
    public function setMulti($multi)
    {
        $this->multi = $multi;

        return $this;
    }

    /**
     * Get multi
     *
     * @return boolean
     */
    public function getMulti()
    {
        return $this->multi;
    }

    /**
     * Set droped
     *
     * @param integer $droped
     *
     * @return PortailInvoc
     */
    public function setDroped($droped)
    {
        $this->droped = $droped;

        return $this;
    }

    /**
     * Get droped
     *
     * @return integer
     */
    public function getDroped()
    {
        return $this->droped;
    }
    
/**
     * Add personnageInvoc
     *
     * @param \GameBundle\Entity\PortailBox $personnageInvoc
     *
     * @return Portail
     */
    public function addPersonnageInvoc(PersonnageInvoc $personnageInvoc)
    {
        $this->personnageInvocs[] = $personnageInvoc;

        return $this;
    }

    /**
     * Remove personnageInvoc
     *
     * @param \GameBundle\Entity\PersonnageInvoc $personnageInvoc
     */
    public function removePersonnageInvoc(PersonnageInvoc $personnageInvoc)
    {
        $this->personnageInvocs->removeElement($personnageInvoc);
    }

    /**
     * Get personnageInvocs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnageInvoces()
    {
        return $this->personnageInvocs;
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
        $p = new PersonnageInvoc();
        $p->setPersonnage($personnage);
        $p->setInvocation($this);
        
        $this->addPersonnageInvoc($p);
        
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
        foreach($this->personnageInvocs as $p)
        {
            if($p->getPersonnage()===$personnage)
            {
                $this->removePersonnageInvoc($p);
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
		
		if(isset($this->personnageInvocs) && !is_null($this->personnageInvocs))
			foreach($this->personnageInvocs as $p)
				$persos[] = $p->getPersonnage();
        
        return $persos ;
        //return $this->personnages;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personnageInvocs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PortailInvoc
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
     * @return PortailInvoc
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
     * @return PortailInvoc
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
     * @return PortailInvoc
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
     * @return PortailInvoc
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

    /**
     * Get personnageInvocs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnageInvocs()
    {
        return $this->personnageInvocs;
    }
}
