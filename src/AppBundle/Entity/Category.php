<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="Categories")
 */
class Category
{
  /**
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @ORM\Column(type="string", length=80)
  */
  private $name;

  /**
  * @ORM\OneToMany(targetEntity="Animal", mappedBy="category")
  */
  private $animals;

  /**
  * @ORM\ManyToMany(targetEntity="DiagnosticProcedure", mappedBy="categories")
  */
  private $diagnostics;

  /**
  * @ORM\ManyToMany(targetEntity="TherapeuticProcedure", mappedBy="categories")
  */
  private $therapeutics;

  public function __construct() {
    $this->animals = new ArrayCollection();
    $this->diagnostics = new ArrayCollection();
    $this->therapeutics = new ArrayCollection();
  }

  public function getId() {
    return $this->id;
  }

  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  public function getName() {
    return $this->name;
  }
}
