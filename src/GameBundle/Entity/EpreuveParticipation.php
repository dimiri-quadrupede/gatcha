<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;

use GameBundle\Entity\Epreuve ;
use GameBundle\Entity\BoxEquipe;

/**
 * EpreuveParticipation
 *
 * @ORM\Table(name="epreuve_participation", indexes={
 *          @ORM\Index(name="Table_16_FKIndex2", columns={"equipe_id"}), 
 *          @ORM\Index(name="Table_16_FKIndex3", columns={"epreuve_id"})
 * })
 * @ORM\Entity
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 */
class EpreuveParticipation
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
     * @var \AppBundle\Entity\Epreuve
     *
     * @ORM\ManyToOne(targetEntity="Epreuve")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="epreuve_id", referencedColumnName="id")
     * })
     */
    private $epreuve;

    /**
     * @var \AppBundle\Entity\BoxEquipe
     *
     * @ORM\ManyToOne(targetEntity="PlayerEquipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe_id", referencedColumnName="id")
     * })
     */
    private $equipe;

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
     * Set epreuve
     *
     * @param \AppBundle\Entity\Epreuve $epreuve
     *
     * @return EpreuveParticipation
     */
    public function setEpreuve(Epreuve $epreuve = null)
    {
        $this->epreuve = $epreuve;

        return $this;
    }

    /**
     * Get epreuve
     *
     * @return \AppBundle\Entity\Epreuve
     */
    public function getEpreuve()
    {
        return $this->epreuve;
    }

    /**
     * Set boxEquipe
     *
     * @param \AppBundle\Entity\BoxEquipe $boxEquipe
     *
     * @return EpreuveParticipation
     */
    public function setBoxEquipe(BoxEquipe $boxEquipe = null)
    {
        $this->boxEquipe = $boxEquipe;

        return $this;
    }

    /**
     * Get boxEquipe
     *
     * @return \AppBundle\Entity\BoxEquipe
     */
    public function getBoxEquipe()
    {
        return $this->boxEquipe;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return EpreuveParticipation
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
     * @return EpreuveParticipation
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
     * @return EpreuveParticipation
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
     * @return EpreuveParticipation
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
     * @return EpreuveParticipation
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
     * Set equipe
     *
     * @param \GameBundle\Entity\PlayerEquipe $equipe
     *
     * @return EpreuveParticipation
     */
    public function setEquipe(\GameBundle\Entity\PlayerEquipe $equipe = null)
    {
        $this->equipe = $equipe;

        return $this;
    }

    /**
     * Get equipe
     *
     * @return \GameBundle\Entity\PlayerEquipe
     */
    public function getEquipe()
    {
        return $this->equipe;
    }
}
