<?php
// src/AppBundle/Entity/TestResults.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diagnostic Test Results class
 *
 * Contains results for a specific diagnostic Test done on a specific Day
 *
 * @see 'AppBundle\Entity\Test'
 * @see 'AppBundle\Entity\Day'
 *
 * @ORM\Entity
 * @ORM\Table(name="TestResults")
 */
class TestResults
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
	 * Associated Day
	 *
	 * @var Day
	 *
	 * @see 'AppBundle\Entity\Day'
	 *
	 * @ORM\ManyToOne(targetEntity="Day", inversedBy="tests")
	 */
	private $day;

	/**
	 * Associated UserDay
	 *
	 * @var UserDay
	 *
	 * @see User'AppBundle\Entity\Day'
	 *
	 * @ORM\ManyToOne(targetEntity="UserDay", inversedBy="tests")
	 * @ORM\JoinColumn(name="user_day_id", referencedColumnName="id", onDelete="SET NULL")
	 */
	private $userDay;

	/**
	 * Associated Test
	 *
	 * @var Test
	 *
	 * @see 'AppBundle\Entity\Test'
	 *
	 * @ORM\ManyToOne(targetEntity="Test", inversedBy="results")
	 */
	private $test;

	/**
	 * The results for the associated Test
	 *
	 * @var string
	 *
	 * @see 'AppBundle\Entity\Test'
	 *
	 * @ORM\Column(type="text")
	 */
	private $results;

	/**
	 * @ORM\Column(type="string", length=4, nullable=true)
	 */
	private $waitTime;

	public function __toString()
	{
		return sprintf("%s: %s", $this->test->getName(), $this->results);
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
     * Set results
     *
     * @param string $results
     *
     * @return self
     */
    public function setResults($results)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * Get results
     *
     * @return string
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set test
     *
     * @param \AppBundle\Entity\Test $test
     *
		 * @see 'AppBundle\Entity\Test'
		 *
     * @return self
     */
    public function setTest(\AppBundle\Entity\Test $test = null)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \AppBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set day
     *
     * @param \AppBundle\Entity\Day $day
		 *
		 * @see 'AppBundle\Entity\Day'
     *
     * @return self
     */
    public function setDay(\AppBundle\Entity\Day $day = null)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \AppBundle\Entity\Day
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set userDay
     *
     * @param \AppBundle\Entity\UserDay $userDay
		 *
		 * @see User'AppBundle\Entity\Day'
     *
     * @return self
     */
    public function setUserDay(\AppBundle\Entity\UserDay $userDay = null)
    {
        $this->userDay = $userDay;

        return $this;
    }

    /**
     * Get userDay
     *
     * @return \AppBundle\Entity\UserDay
     */
    public function getUserDay()
    {
        return $this->userDay;
    }

    /**
     * Set waitTime
     *
     * @param string $waitTime
     *
     * @return TestResults
     */
    public function setWaitTime($waitTime)
    {
        $this->waitTime = $waitTime;

        return $this;
    }

    /**
     * Get waitTime
     *
     * @return string
     */
    public function getWaitTime()
    {
        return $this->waitTime;
    }
}
