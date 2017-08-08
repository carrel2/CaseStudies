<?php
// src/AppBundle/Entity/HotSpotInfo.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HotSpotInfo class
 *
 * Contains information about a specific HotSpot of an Animal for a specific Day
 *
 * @see HotSpot::class
 * @see 'AppBundle\Entity\Animal'
 * @see 'AppBundle\Entity\Day'
 *
 * @ORM\Entity
 * @ORM\Table(name="HotSpotsInfo")
 */
class HotSpotInfo
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
	 * @see 'AppBundle\Entity\Day'
	 *
	 * @ORM\ManyToOne(targetEntity="Day", inversedBy="hotspotsInfo")
	 */
	private $day;

	/**
	 * Associated UserDay
	 *
	 * @var UserDay
	 *
	 * @see User'AppBundle\Entity\Day'
	 *
	 * @ORM\ManyToOne(targetEntity="UserDay", inversedBy="hotspotsInfo")
	 * @ORM\JoinColumn(name="user_day_id", referencedColumnName="id", onDelete="SET NULL")
	 */
	private $userDay;

	/**
	 * The name of the HotSpot object
	 *
	 * @var HotSpot
	 *
	 * @ORM\ManyToOne(targetEntity="HotSpot", inversedBy="info")
	 */
	private $hotspot;

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
     * Set info
     *
     * @param string $info
     *
     * @return HotSpotInfo
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
     * @return HotSpotInfo
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
     * @param \AppBundle\Entity\UserDay $userDay
     *
     * @return HotSpotInfo
     */
    public function setUserDay(\AppBundle\Entity\UserDay $userDay = null)
    {
        $this->userDay = $userDay;

        return $this;
    }

    /**
     * Get userDay
     *
     * @return \AppBundle\Entity\UserDay
     */
    public function getUserDay()
    {
        return $this->userDay;
    }

    /**
     * Set hotspot
     *
     * @param \AppBundle\Entity\HotSpot $hotspot
     *
     * @return HotSpotInfo
     */
    public function setHotspot(\AppBundle\Entity\HotSpot $hotspot = null)
    {
        $this->hotspot = $hotspot;

        return $this;
    }

    /**
     * Get hotspot
     *
     * @return \AppBundle\Entity\HotSpot
     */
    public function getHotspot()
    {
        return $this->hotspot;
    }
}
