<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity
 */
class Player extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="experience", type="integer", nullable=true)
     */
    private $experience;

    /**
     * @var integer
     *
     * @ORM\Column(name="vie", type="integer", nullable=true)
     */
    private $vie;

    /**
     * @var integer
     *
     * @ORM\Column(name="endurance", type="integer", nullable=true)
     */
    private $endurance;

    /**
     * @var boolean $locale
     *
     * @ORM\Column(name="locale", type="string", length=5, nullable=false)
     */
    private $locale = 'fr';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;


	public function __construct()
	{
		parent::__construct();
		// your own logic
	}
        
        public function __toString() {

            return $this->getUsername();
        }

    /**
     * Set experience
     *
     * @param integer $experience
     *
     * @return Player
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return integer
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set vie
     *
     * @param integer $vie
     *
     * @return Player
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
     * Set endurance
     *
     * @param integer $endurance
     *
     * @return Player
     */
    public function setEndurance($endurance)
    {
        $this->endurance = $endurance;

        return $this;
    }

    /**
     * Get endurance
     *
     * @return integer
     */
    public function getEndurance()
    {
        return $this->endurance;
    }

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return Player
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
