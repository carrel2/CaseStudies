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
   * The associated Animal
   *
   * @var Animal
   *
   * @see Animal::class
   *
   * @ORM\ManyToOne(targetEntity="Animal", inversedBy="hotspots")
   */
  private $animal;

  /**
   * The name of the HotSpot
   *
   * @var string
   *
   * @ORM\Column(type="string")
   */
  private $name;

  /**
   * The x1 coordinate of the HotSpot
   *
   * @var integer
   *
   * @ORM\Column(type="integer")
   */
  private $x1;

  /**
   * The x2 coordinate of the HotSpot
   *
   * @var integer
   *
   * @ORM\Column(type="integer")
   */
  private $x2;

  /**
   * The y1 coordinate of the HotSpot
   *
   * @var integer
   *
   * @ORM\Column(type="integer")
   */
  private $y1;

  /**
   * The y2 coordinate of the HotSpot
   *
   * @var integer
   *
   * @ORM\Column(type="integer")
   */
  private $y2;

  /**
   * An ArrayCollection of HotSpotInfo objects for the HotSpot
   *
   * @var ArrayCollection
   *
   * @ORM\OneToMany(targetEntity="HotSpotInfo", mappedBy="hotspot", cascade={"all"})
   */
   private $info;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->info = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return HotSpot
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
     * Set x1
     *
     * @param integer $x1
     *
     * @return HotSpot
     */
    public function setX1($x1)
    {
        $this->x1 = $x1;

        return $this;
    }

    /**
     * Get x1
     *
     * @return integer
     */
    public function getX1()
    {
        return $this->x1;
    }

    /**
     * Set x2
     *
     * @param integer $x2
     *
     * @return HotSpot
     */
    public function setX2($x2)
    {
        $this->x2 = $x2;

        return $this;
    }

    /**
     * Get x2
     *
     * @return integer
     */
    public function getX2()
    {
        return $this->x2;
    }

    /**
     * Set y1
     *
     * @param integer $y1
     *
     * @return HotSpot
     */
    public function setY1($y1)
    {
        $this->y1 = $y1;

        return $this;
    }

    /**
     * Get y1
     *
     * @return integer
     */
    public function getY1()
    {
        return $this->y1;
    }

    /**
     * Set y2
     *
     * @param integer $y2
     *
     * @return HotSpot
     */
    public function setY2($y2)
    {
        $this->y2 = $y2;

        return $this;
    }

    /**
     * Get y2
     *
     * @return integer
     */
    public function getY2()
    {
        return $this->y2;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
      return $this->y2 - $this->y1;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
      return $this->x2 - $this->x1;
    }

    /**
     * Set animal
     *
     * @param \AppBundle\Entity\Animal $animal
     *
     * @return HotSpot
     */
    public function setAnimal(\AppBundle\Entity\Animal $animal = null)
    {
        $this->animal = $animal;

        return $this;
    }

    /**
     * Get animal
     *
     * @return \AppBundle\Entity\Animal
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * Add info
     *
     * @param \AppBundle\Entity\HotSpotInfo $info
     *
     * @return HotSpot
     */
    public function addHotSpotInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
        $this->info[] = $info;

        return $this;
    }

    /**
     * Remove info
     *
     * @param \AppBundle\Entity\HotSpotInfo $info
     */
    public function removeHotSpotInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
        $this->info->removeElement($info);
    }

    /**
     * Get info
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Add info
     *
     * @param \AppBundle\Entity\HotSpotInfo $info
     *
     * @return HotSpot
     */
    public function addInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
        $this->info[] = $info;

        return $this;
    }

    /**
     * Remove info
     *
     * @param \AppBundle\Entity\HotSpotInfo $info
     */
    public function removeInfo(\AppBundle\Entity\HotSpotInfo $info)
    {
        $this->info->removeElement($info);
    }
}
