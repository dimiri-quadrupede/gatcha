<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Player;
use AppBundle\Entity\UploadableFile;

/**
 * Personnage
 *
 * @ORM\Table(name="personnage")
 * @ORM\Entity(repositoryClass="GameBundle\Repository\PersonnageRepository")
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 */
class Personnage
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="attaque", type="integer", nullable=true)
     */
    private $attaque;

    /**
     * @var integer
     *
     * @ORM\Column(name="defense", type="integer", nullable=true)
     */
    private $defense;

    /**
     * @var integer
     *
     * @ORM\Column(name="vie", type="integer", nullable=true)
     */
    private $vie;

    /**
     * @var \AppBundle\Entity\Personnage
     *
     * @ORM\ManyToOne(targetEntity="Personnage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="evolution_id", referencedColumnName="id")
     * })
     */
    private $evolution;

    /**
     * @var \AppBundle\Entity\Rarete
     *
     * @ORM\ManyToOne(targetEntity="Rarete")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rarete_id", referencedColumnName="id")
     * })
     */
    private $rarete;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Gedmo\Slug(fields={"name", "id"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var UploadableFile
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UploadableFile", cascade={"persist"} )
     * @Gedmo\Versioned
     */
    private $icon;

     /**
     * @var UploadableFile
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UploadableFile", cascade={"persist"} )
     * @Gedmo\Versioned
     */
    private $card;
   
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
     * One Portail has Many PortailBox.
     * @ORM\OneToMany(targetEntity="PortailBox", mappedBy="personnage")
     */
    private $portailBoxes ;
    
    /**
     * One Portail has Many PortailBox.
     * @ORM\OneToMany(targetEntity="PlayerBox", mappedBy="personnage")
     */
    private $playerBoxes ;

    public function __construct() 
    {
        $this->portailBoxes = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getSlug();
    }

        /**
     * Set name
     *
     * @param string $name
     *
     * @return Personnage
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
     * Set attaque
     *
     * @param integer $attaque
     *
     * @return Personnage
     */
    public function setAttaque($attaque)
    {
        $this->attaque = $attaque;

        return $this;
    }

    /**
     * Get attaque
     *
     * @return integer
     */
    public function getAttaque()
    {
        return $this->attaque;
    }

    /**
     * Set defense
     *
     * @param integer $defense
     *
     * @return Personnage
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * Get defense
     *
     * @return integer
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * Set vie
     *
     * @param integer $vie
     *
     * @return Personnage
     */
    public function setVie($vie)
    {
        $this->vie = $vie;

        return $this;
    }

    /**
     * Get vie
     *
     * @return integer
     */
    public function getVie()
    {
        return $this->vie;
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
    
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Personnage
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Personnage
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
     * @return Personnage
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
     * @return Personnage
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
     * @return Personnage
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
     * @return Personnage
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
     * Set evolution
     *
     * @param \GameBundle\Entity\Personnage $evolution
     *
     * @return Personnage
     */
    public function setEvolution(\GameBundle\Entity\Personnage $evolution = null)
    {
        $this->evolution = $evolution;

        return $this;
    }

    /**
     * Get evolution
     *
     * @return \GameBundle\Entity\Personnage
     */
    public function getEvolution()
    {
        return $this->evolution;
    }

    /**
     * Set rarete
     *
     * @param \GameBundle\Entity\Rarete $rarete
     *
     * @return Personnage
     */
    public function setRarete(\GameBundle\Entity\Rarete $rarete = null)
    {
        $this->rarete = $rarete;

        return $this;
    }

    /**
     * Get rarete
     *
     * @return \GameBundle\Entity\Rarete
     */
    public function getRarete()
    {
        return $this->rarete;
    }

    /**
     * Add portailBox
     *
     * @param \GameBundle\Entity\PortailBox $portailBox
     *
     * @return Personnage
     */
    public function addPortailBox(\GameBundle\Entity\PortailBox $portailBox)
    {
        $this->portailBoxes[] = $portailBox;

        return $this;
    }

    /**
     * Remove portailBox
     *
     * @param \GameBundle\Entity\PortailBox $portailBox
     */
    public function removePortailBox(\GameBundle\Entity\PortailBox $portailBox)
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
     * Add playerBox
     *
     * @param \GameBundle\Entity\PlayerBox $playerBox
     *
     * @return Personnage
     */
    public function addPlayerBox(\GameBundle\Entity\PlayerBox $playerBox)
    {
        $this->playerBoxes[] = $playerBox;

        return $this;
    }

    /**
     * Remove playerBox
     *
     * @param \GameBundle\Entity\PlayerBox $playerBox
     */
    public function removePlayerBox(\GameBundle\Entity\PlayerBox $playerBox)
    {
        $this->playerBoxes->removeElement($playerBox);
    }

    /**
     * Get playerBoxes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayerBoxes()
    {
        return $this->playerBoxes;
    }
    
    public function getBoxesPlayer(Player $player)
    {
        $boxes = array();
        
        foreach($this->playerBoxes as $box)
        {
            if($player === $box->getPlayer())
            {
                $boxes[] = $box ;
            }
        }
        
        return $boxes ;
    }

    /**
     * Set icon
     *
     * @param string $icon
     */
    public function setIcon( $icon )
    {
        $this->icon = $icon;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

	/**
	 * Get icon URL
	 *
	 * @return string
    public function getIconURL()
    {
        return $this->icon === null ? null : $this->icon->getURL();
    }
	 */
    

    /**
     * Set card
     *
     * @param \AppBundle\Entity\UploadableFile $card
     *
     * @return Personnage
     */
    public function setCard(\AppBundle\Entity\UploadableFile $card = null)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Get card
     *
     * @return \AppBundle\Entity\UploadableFile
     */
    public function getCard()
    {
        return $this->card;
    }
}
