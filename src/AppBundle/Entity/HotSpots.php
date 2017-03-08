<?php
// src/AppBundle/Entity/HotSpots.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotSpots class
 *
 * Contains information about a specific location of an animal for a specific Day
 *
 * @see Day::class
 *
 * @ORM\Entity
 * @ORM\Table(name="Hotspots")
 */
class HotSpots
{
	/**
	 * Auto-generated unique id
	 *
	 * @var integer
	 *
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * Associated Day
	 *
	 * @var Day
	 *
	 * @see Day::class
	 *
	 * @ORM\ManyToOne(targetEntity="Day", inversedBy="hotspots")
	 * @ORM\JoinColumn(name="day_id", referencedColumnName="id")
	 */
	private $day;

	/**
	 * Associated UserDay
	 *
	 * @var UserDay
	 *
	 * @see UserDay::class
	 *
	 * @ORM\ManyToOne(targetEntity="UserDay", inversedBy="hotspots")
	 */
	private $userDay;

	/**
	 * The name of the HotSpots
	 *
	 * @var string
	 *
	 * @ORM\Column(type="string", length=40)
	 */
	private $name;

	/**
	 * Information about the HotSpots
	 *
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	private $info;

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
     * Set name
     *
     * @param string $name
     *
     * @return self
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
     * Set info
     *
     * @param string $info
     *
     * @return self
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set day
     *
     * @param \AppBundle\Entity\Day $day
		 *
		 * @see Day::class
     *
     * @return self
     */
    public function setDay(\AppBundle\Entity\Day $day = null)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \AppBundle\Entity\Day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set userDay
     *
     * @param \AppBundle\Entity\UserDays $userDay
		 *
		 * @see UserDay::class
     *
     * @return self
     */
    public function setUserDay(\AppBundle\Entity\UserDay $userDay = null)
    {
        $this->userDay = $userDay;

        return $this;
    }

    /**
     * Get userDay
     *
     * @return \AppBundle\Entity\UserDays
     */
    public function getUserDay()
    {
        return $this->userDay;
    }
}
