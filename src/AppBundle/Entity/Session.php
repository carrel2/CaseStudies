<?php
// src/AppBundle/Entity/Session.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Sessions")
 */
class Session
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\OneToMany(targetEntity="Day", mappedBy="session")
	 */
	private $days;

	/**
	 * @ORM\ManyToOne(targetEntity="CaseStudy", inversedBy="sessions")
	 * @ORM\JoinColumn(name="case_id", referencedColumnName="id")
	 */
	private $caseStudy;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $userId;

    public function __construct()
    {
        $this->days = new ArrayCollection();
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Session
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set caseStudy
     *
     * @param \AppBundle\Entity\CaseStudy $caseStudy
     *
     * @return Session
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

    /**
     * Add day
     *
     * @param \AppBundle\Entity\Day $day
     *
     * @return Session
     */
    public function addDay(\AppBundle\Entity\Day $day)
    {
        $this->days[] = $day;

        return $this;
    }

    /**
     * Remove day
     *
     * @param \AppBundle\Entity\Day $day
     */
    public function removeDay(\AppBundle\Entity\Day $day)
    {
        $this->days->removeElement($day);
    }

    /**
     * Get days
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Get current day
     *
     * @return \AppBundle\Entity\Day
     */
    public function getCurrentDay()
    {
        return $this->days->last();
    }
}
