<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="HotSpots")
 */
class NewHotSpot
{
  /**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

  /**
   * @ORM\ManyToOne(targetEntity="Animal", inversedBy="hotspots")
   */
  private $animal;

  /**
   * @ORM\Column(type="string")
   */
  private $name;

  /**
   * @ORM\Column(type="array")
   */
  private $coords;

  /**
   * @ORM\OneToMany(targetEntity="HotSpotInfo", mappedBy="hotspot", cascade={"all"})
   */
   private $info;

    public function __construct()
    {
        $this->info = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCoords($coords)
		{
			$this->coords = $coords;

			return $this;
		}

		public function getCoords()
		{
			return $this->coords;
		}

    public function setAnimal(\AppBundle\Entity\Animal $animal = null)
    {
        $this->animal = $animal;

        return $this;
    }

    public function getAnimal()
    {
        return $this->animal;
    }

    public function addInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
				if( !$this->info->contains($info) ) {
					$info->setHotspot($this);
					$this->info->add($info);
				}

        return $this;
    }

    public function removeInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
				$info->setHotspot(null);
        $this->info->removeElement($info);

				return $this;
    }

    public function getInfo()
    {
        return $this->info;
    }
}
