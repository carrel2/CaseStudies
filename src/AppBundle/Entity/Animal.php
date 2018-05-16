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
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @ORM\OneToMany(targetEntity="CaseStudy", mappedBy="animal")
  */
  private $cases;

  /**
  * @ORM\Column(type="string", length=80)
  */
  private $name;

  /**
   * @ORM\Column(type="decimal", scale=2)
   */
  private $weight;

  /**
  * @ORM\Column(type="string")
  */
  private $image; // TODO: look into having multiple images associated with an Animal

  /**
  * @ORM\OneToMany(targetEntity="HotSpot", mappedBy="animal", cascade={"all"}, orphanRemoval=true)
  */
  private $hotspots;

  public function __construct()
  {
    $this->cases = new ArrayCollection();
    $this->hotspots = new ArrayCollection();
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

    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function addCase(\AppBundle\Entity\CaseStudy $case)
    {
        $case->setAnimal($this);
        $this->cases[] = $case;

        return $this;
    }

    public function removeCase(\AppBundle\Entity\CaseStudy $case)
    {
        $case->setAnimal(null);
        $this->cases->removeElement($case);
    }

    public function getCases()
    {
        return $this->cases;
    }

    public function addHotspot(\AppBundle\Entity\HotSpot $hotspot)
    {
        $hotspot->setAnimal($this);
        $this->hotspots[] = $hotspot;

        return $this;
    }

    public function removeHotspot(\AppBundle\Entity\HotSpot $hotspot)
    {
        $hotspot->setAnimal(null);
        $this->hotspots->removeElement($hotspot);
    }

    public function getHotspots()
    {
        return $this->hotspots;
    }
}
