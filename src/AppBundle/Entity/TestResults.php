<?php
// src/AppBundle/Entity/TestResults.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
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
	 * @ORM\JoinColumn(name="user_day_id", referencedColumnName="id", onDelete="SET NULL")
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
	 * @ORM\Column(type="string", length=4, nullable=true)
	 */
	private $waitTime;

	/**
	 * @ORM\Column(type="decimal", scale=2, nullable=true)
	 */
	private $cost;

	public function __toString()
	{
		return sprintf("%s: %s", $this->test->getName(), $this->results);
	}

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

    public function setTest(\AppBundle\Entity\Test $test = null)
    {
        $this->test = $test;

        return $this;
    }

    public function getTest()
    {
        return $this->test;
    }

    public function setDay(\AppBundle\Entity\Day $day = null)
    {
        $this->day = $day;

        return $this;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function setUserDay(\AppBundle\Entity\UserDay $userDay = null)
    {
        $this->userDay = $userDay;

        return $this;
    }

    public function getUserDay()
    {
        return $this->userDay;
    }

    public function setWaitTime($waitTime)
    {
        $this->waitTime = $waitTime;

        return $this;
    }

    public function getWaitTime()
    {
        return $this->waitTime;
    }

		public function setCost($cost)
		{
				$this->cost = $cost;

				return $this;
		}

		public function getCost()
		{
				return $this->cost;
		}
}
