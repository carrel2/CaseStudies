<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="HotSpots")
 */
class HotSpot
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
   * @ORM\Column(type="float")
   */
  private $x1;

  /**
   * @ORM\Column(type="float")
   */
  private $x2;

  /**
   * @ORM\Column(type="float")
   */
  private $y1;

  /**
   * @ORM\Column(type="float")
   */
  private $y2;

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

    public function setX1($x1)
    {
        $this->x1 = $x1;

        return $this;
    }

    public function getX1()
    {
        return $this->x1;
    }

    public function setX2($x2)
    {
        $this->x2 = $x2;

        return $this;
    }

    public function getX2()
    {
        return $this->x2;
    }

    public function setY1($y1)
    {
        $this->y1 = $y1;

        return $this;
    }

    public function getY1()
    {
        return $this->y1;
    }

    public function setY2($y2)
    {
        $this->y2 = $y2;

        return $this;
    }

    public function getY2()
    {
        return $this->y2;
    }

    public function getHeight()
    {
      return $this->y2 - $this->y1;
    }

    public function getWidth()
    {
      return $this->x2 - $this->x1;
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

    public function addHotSpotInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
        $this->info[] = $info;

        return $this;
    }

    public function removeHotSpotInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
        $this->info->removeElement($info);
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function addInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
        $this->info[] = $info;

        return $this;
    }

    public function removeInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
        $this->info->removeElement($info);
    }
}
