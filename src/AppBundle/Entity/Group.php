<?php

namespace Provalliance\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use FOS\UserBundle\Model\GroupInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Provalliance\UserBundle\Repository\GroupRepository")
 * @ORM\Table(name="player_group")
 * @Gedmo\Loggable
 */
class Group extends BaseGroup implements GroupInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Player", mappedBy="groups")
     *
     */
    protected $users;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     * @Gedmo\Versioned
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     * @Gedmo\Versioned
     */
    private $updatedAt;

    /**
     * @var string $createdBy
     *
     * @ORM\Column(name="created_by", type="string")
     * @Gedmo\Blameable(on="create")
     * @Gedmo\Versioned
     */
    private $createdBy;

    /**
     * @var string $updatedBy
     *
     * @ORM\Column(name="updated_by", type="string")
     * @Gedmo\Blameable(on="update")
     * @Gedmo\Versioned
     */
    private $updatedBy;

    public function __construct( $name = '', $roles = array( ) )
    {
            $this->name = $name;
            $this->roles = $roles;
    }

    public function getUsers()
    {
            return $this->users;
    }

    public function setUsers( $users )
    {
            $this->users = $users;
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

    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return PermissionGroup
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
     * @return PermissionGroup
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
     * @return PermissionGroup
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
     * @return PermissionGroup
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    
        return $this;
    }

    /**
     * Add users
     *
     * @param \Provalliance\UserBundle\Entity\User $users
     * @return PermissionGroup
     */
    public function addUser(\Provalliance\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Provalliance\UserBundle\Entity\User $users
     */
    public function removeUser(\Provalliance\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Add dashboardMessages
     *
     * @param \Provalliance\DashboardBundle\Entity\DashboardMessage $dashboardMessages
     * @return PermissionGroup
     */
    public function addDashboardMessage(\Provalliance\DashboardBundle\Entity\DashboardMessage $dashboardMessages)
    {
        $this->dashboardMessages[] = $dashboardMessages;
    
        return $this;
    }

    /**
     * Remove dashboardMessages
     *
     * @param \Provalliance\DashboardBundle\Entity\DashboardMessage $dashboardMessages
     */
    public function removeDashboardMessage(\Provalliance\DashboardBundle\Entity\DashboardMessage $dashboardMessages)
    {
        $this->dashboardMessages->removeElement($dashboardMessages);
    }
}