<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use GameBundle\Entity\Epreuve;
use GameBundle\Entity\Money;

/**
 * EpreuveReward
 *
 * @ORM\Table(name="epreuve_reward", indexes={@ORM\Index(name="Table_24_FKIndex1", columns={"money_id"}), @ORM\Index(name="personnage_reward_FKIndex2", columns={"epreuve_id"})})
 * @ORM\Entity
 * @Gedmo\Loggable
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 */
class EpreuveReward
{
    /**
     * @var integer
     *
     * @ORM\Column(name="nbre", type="integer", nullable=true)
     */
    private $nbre;

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
     * @var \AppBundle\Entity\Money
     *
     * @ORM\ManyToOne(targetEntity="Money")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="money_id", referencedColumnName="id")
     * })
     */
    private $money;

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
     * Set nbre
     *
     * @param integer $nbre
     *
     * @return EpreuveReward
     */
    public function setNbre($nbre)
    {
        $this->nbre = $nbre;

        return $this;
    }

    /**
     * Get nbre
     *
     * @return integer
     */
    public function getNbre()
    {
        return $this->nbre;
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
     * Set epreuve
     *
     * @param \AppBundle\Entity\Epreuve $epreuve
     *
     * @return EpreuveReward
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
     * Set money
     *
     * @param \AppBundle\Entity\Money $money
     *
     * @return EpreuveReward
     */
    public function setMoney(Money $money = null)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return \AppBundle\Entity\Money
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return EpreuveReward
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
     * @return EpreuveReward
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
     * @return EpreuveReward
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
     * @return EpreuveReward
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
     * @return EpreuveReward
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
