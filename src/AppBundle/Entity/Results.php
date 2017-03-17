<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
  * The UserDays associated with the Results
  *
  * @var ArrayCollection
  *
  * @see UserDay::class
  * @see ArrayCollection::class
  *
  * @ORM\OneToMany(targetEntity="UserDay", mappedBy="results", cascade={"persist"})
  */
  private $userDays;

  /**
  * The CaseStudy associated with the Results
  *
  * @var CaseStudy
  *
  * @see CaseStudy::class
  *
  * @ORM\ManyToOne(targetEntity="CaseStudy", inversedBy="results")
  */
  private $caseStudy;

  /**
  * Constructor function
  *
  * Initializes $userDays as ArrayCollection
  *
  * @see ArrayCollection::class
  */
  public function __construct() {
    $this->userDays = new ArrayCollection();
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
  * Add userDay
  *
  * @param \AppBundle\Entity\UserDay $userDay
  *
  * @return Results
  */
  public function addUserDay(\AppBundle\Entity\UserDay $userDay)
  {
    $userDay->setResults($this);
    $this->userDays[] = $userDay;

    return $this;
  }

  /**
  * Remove userDay
  *
  * @param \AppBundle\Entity\UserDay $userDay
  */
  public function removeUserDay(\AppBundle\Entity\UserDay $userDay)
  {
    $userDay->setResults(null);
    $this->userDays->removeElement($userDay);
  }

  /**
  * Get userDays
  *
  * @return \Doctrine\Common\Collections\Collection
  */
  public function getUserDays()
  {
    return $this->userDays;
  }

  public function removeDays()
  {
    foreach( $this->userDays as $day ) {
      $this->removeUserDay($day);
    }
  }

  /**
  * Set caseStudy
  *
  * @param \AppBundle\Entity\CaseStudy $caseStudy
  *
  * @return Results
  */
  public function setCaseStudy(\AppBundle\Entity\CaseStudy $caseStudy = null)
  {
    $this->caseStudy = $caseStudy;

    return $this;
  }

  /**
  * Get caseStudy
  *
  * @return \AppBundle\Entity\CaseStudy
  */
  public function getCaseStudy()
  {
    return $this->caseStudy;
  }
}
