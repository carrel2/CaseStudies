<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="Results")
*/
class Results
{
  /**
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @ORM\ManyToOne(targetEntity="User", inversedBy="results")
  */
  private $user;

  /**
  * @ORM\Column(type="text")
  */
  private $caseStudy;

  /**
  * @ORM\Column(type="array")
  */
  private $results;

  /**
  * @ORM\Column(type="string", length=8)
  */
  private $location;

  /**
  * @ORM\Column(type="text")
  */
  private $diagnosis;

    public function getId()
    {
        return $this->id;
    }

    public function setResults($results)
    {
        $this->results = $results;

        return $this;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function add($element)
    {
      $this->results[] = $element;

      return $this;
    }

    public function setDiagnosis($d)
    {
      $this->diagnosis = $d;

      return $this;
    }

    public function getDiagnosis()
    {
      return $this->diagnosis;
    }

    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setCaseStudy($caseStudy)
    {
        $this->caseStudy = $caseStudy;

        return $this;
    }

    public function getCaseStudy()
    {
        return $this->caseStudy;
    }

    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }
}
