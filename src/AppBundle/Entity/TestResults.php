<?php
// src/AppBundle/Entity/TestResults.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diagnostic Test Results class
 *
 * Contains results for a specific diagnostic test done on a specific day
 *
 * @ORM\Entity
 * @ORM\Table(name="TestResults")
 */
class TestResults
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Day", inversedBy="tests")
	 */
	private $day;

	/**
	 * @ORM\ManyToOne(targetEntity="UserDay", inversedBy="tests")
	 */
	private $userDay;

	/**
	 * @ORM\ManyToOne(targetEntity="Test", inversedBy="results")
	 */
	private $test;

	/**
	 * @ORM\Column(type="text")
	 */
	private $results;

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
     * @return TestResults
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
     * @return TestResults
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
     * @return TestResults
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
     * @return TestResults
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
}
