<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Results class
*
* Contains results for a User
*
* @ORM\Entity
* @ORM\Table(name="Results")
*/
class Results
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
  * The User associated with the Results
  *
  * @var User
  *
  * @see User::class
  *
  * @ORM\ManyToOne(targetEntity="User", inversedBy="results")
  */
  private $user;

  /**
  * The name of the CaseStudy associated with the Results object
  *
  * @see CaseStudy::class
  *
  * @var string
  *
  * @ORM\Column(type="text")
  */
  private $caseStudy;

  /**
  * An array that holds all the results for the associated User
  *
  * @see User::class
  *
  * @var string
  *
  * @ORM\Column(type="array")
  */
  private $results;

  /**
  * @ORM\Column(type="string", length=8)
  */
  private $location;

  /**
  * The diagnosis submitted
  *
  * @var string
  *
  * @ORM\Column(type="text")
  */
  private $diagnosis;

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
     * Set results
     *
     * @param array $results
     *
     * @return Results
     */
    public function setResults($results)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * Get results
     *
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Add an element to $results
     *
     * @param object $element
     *
     * @return self
     */
    public function add($element)
    {
      $this->results[] = $element;

      return $this;
    }

    /**
     * Set diagnosis
     *
     * @param string $d
     *
     * @return self
     */
    public function setDiagnosis($d)
    {
      $this->diagnosis = $d;

      return $this;
    }

    /**
     * Get diagnosis
     *
     * @return string
     */
    public function getDiagnosis()
    {
      return $this->diagnosis;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Results
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set caseStudy
     *
     * @param string $caseStudy
     *
     * @return Results
     */
    public function setCaseStudy($caseStudy)
    {
        $this->caseStudy = $caseStudy;

        return $this;
    }

    /**
     * Get caseStudy
     *
     * @return string
     */
    public function getCaseStudy()
    {
        return $this->caseStudy;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Results
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
}
