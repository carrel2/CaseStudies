<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Entity
* @ORM\Table(name="Animals")
* @UniqueEntity(fields="name", message="This animal already exists")
*/
class Animal
{
  /**
  * Auto-generated unique id
  *
  * @var integer Unique id
  *
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * The CaseStudy objects associated with the Animal
  *
  * @var ArrayCollection
  *
  * @see CaseStudy::class
  * @see ArrayCollection::class
  *
  * @ORM\OneToMany(targetEntity="CaseStudy", mappedBy="animal")
  */
  private $cases;

  /**
  * @ORM\Column(type="string", length=40)
  */
  private $name;

  /**
  * @ORM\Column(type="string")
  * @Assert\File(mimeTypes={"image/*"})
  */
  private $image;

  /**
  * @ORM\OneToMany(targetEntity="HotSpot", mappedBy="animal", cascade={"all"}, orphanRemoval=true)
  */
  private $hotspots;

  public function __construct()
  {
    $this->cases = new ArrayCollection();
    $this->hotspots = new ArrayCollection();
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
     * @return Animal
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
     * Set image
     *
     * @param string $image
     *
     * @return Animal
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add case
     *
     * @param \AppBundle\Entity\CaseStudy $case
     *
     * @return Animal
     */
    public function addCase(\AppBundle\Entity\CaseStudy $case)
    {
        $case->setAnimal($this);
        $this->cases[] = $case;

        return $this;
    }

    /**
     * Remove case
     *
     * @param \AppBundle\Entity\CaseStudy $case
     */
    public function removeCase(\AppBundle\Entity\CaseStudy $case)
    {
        $case->setAnimal(null);
        $this->cases->removeElement($case);
    }

    /**
     * Get cases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCases()
    {
        return $this->cases;
    }

    /**
     * Add hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     *
     * @return Animal
     */
    public function addHotspot(\AppBundle\Entity\HotSpot $hotspot)
    {
        $hotspot->setAnimal($this);
        $this->hotspots[] = $hotspot;

        return $this;
    }

    /**
     * Remove hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     */
    public function removeHotspot(\AppBundle\Entity\HotSpot $hotspot)
    {
        $hotspot->setAnimal(null);
        $this->hotspots->removeElement($hotspot);
    }

    /**
     * Get hotspots
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHotspots()
    {
        return $this->hotspots;
    }
}