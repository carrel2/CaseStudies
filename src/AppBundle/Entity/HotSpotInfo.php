<?php
// src/AppBundle/Entity/HotSpotInfo.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="HotSpotsInfo")
 */
class HotSpotInfo
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Day", inversedBy="hotspotsInfo")
	 */
	private $day;

	/**
	 * @ORM\ManyToOne(targetEntity="UserDay", inversedBy="hotspotsInfo")
	 * @ORM\JoinColumn(name="user_day_id", referencedColumnName="id", onDelete="SET NULL")
	 */
	private $userDay;

	/**
	 * @ORM\ManyToOne(targetEntity="HotSpot", inversedBy="info")
	 */
	private $hotspot;

	/**
	 * @ORM\Column(type="text")
	 */
	private $info;

    public function getId()
    {
        return $this->id;
    }

    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    public function getInfo()
    {
        return $this->info;
    }

		public function setDay(\AppBundle\Entity\Day $day)
		{
				$this->day = $day;

				return $this;
		}

		public function getDay()
		{
				return $this->day;
		}

		public function setUserDay(\AppBundle\Entity\UserDay $userDay)
		{
				$this->userDay = $userDay;

				return $this;
		}

		public function getUserDay()
		{
				return $this->userDay;
		}

    public function setHotspot(\AppBundle\Entity\HotSpot $hotspot = null)
    {
        $this->hotspot = $hotspot;

        return $this;
    }

    public function getHotspot()
    {
        return $this->hotspot;
    }
}
