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
