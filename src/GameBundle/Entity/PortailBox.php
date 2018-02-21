<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;

use GameBundle\Entity\Portail;
use GameBundle\Entity\Personnage;

/**
 * PortailBox
 *
 * @ORM\Table(name="portail_box", indexes={@ORM\Index(name="personnage_has_portail_FKIndex1", columns={"personnage_id"}), @ORM\Index(name="personnage_has_portail_FKIndex2", columns={"portail_id"})})
 * @ORM\Entity
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 */
class PortailBox
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
     * @ORM\Column(name="drop_rate", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $dropRate;


    /**
     * @var \AppBundle\Entity\Portail
     *
     * @ORM\ManyToOne(targetEntity="Portail", inversedBy="portailBoxes",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="portail_id", referencedColumnName="id")
     * })
     */
    private $portail;

    /**
     * @var \AppBundle\Entity\Personnage
     *
     * @ORM\ManyToOne(targetEntity="Personnage", inversedBy="portailBoxes",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personnage_id", referencedColumnName="id")
     * })
     */
    private $personnage;

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


    public function __toString() {
        
        return $this->getPersonnage() ;
    }

    /**
     * Set dropRate
     *
     * @param string $dropRate
     *
     * @return PortailBox
     */
    public function setDropRate($dropRate)
    {
        $this->dropRate = $dropRate;

        return $this;
    }

    /**
     * Get dropRate
     *
     * @return string
     */
    public function getDropRate()
    {
        return $this->dropRate;
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

    /**
     * Set portail
     *
     * @param \AppBundle\Entity\Portail $portail
     *
     * @return PortailBox
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
     * Set personnage
     *
     * @param \AppBundle\Entity\Personnage $personnage
     *
     * @return PortailBox
     */
    public function setPersonnage(Personnage $personnage = null)
    {
        $this->personnage = $personnage;

        return $this;
    }

    /**
     * Get personnage
     *
     * @return \AppBundle\Entity\Personnage
     */
    public function getPersonnage()
    {
        return $this->personnage;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PortailBox
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
     * @return PortailBox
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
     * @return PortailBox
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
     * @return PortailBox
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
     * @return PortailBox
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
