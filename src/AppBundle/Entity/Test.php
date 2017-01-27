<?php
// src/AppBundle/Entity/Test.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Tests")
 */
class Test
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $caseId;

	/**
	 * @ORM\Column(type="string", length=40)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=10)
	 */
	private $cost;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $wait;

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
	 * Set case
	 *
	 * @param integer $case
	 *
	 * @return Test
	 */
	public function setCaseId($case)
	{
		$this->caseId = $case;

		return $this;
	}

	/**
	 * Get case
	 *
	 * @return integer
	 */
	public function getCaseId()
	{
		return $this->caseId;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Test
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
	 * Set cost
	 *
	 * @param string $cost
	 *
	 * @return Test
	 */
	public function setCost($cost)
	{
		$this->cost = $cost;

		return $this;
	}

	/**
	 * Get cost
	 *
	 * @return string
	 */
	public function getCost()
	{
		return $this->cost;
	}

	/**
	 * Set wait
	 *
	 * @param integer $wait
	 *
	 * @return Test
	 */
	public function setWait($wait)
	{
		$this->wait = $wait;

		return $this;
	}

	/**
	 * Get wait
	 *
	 * @return integer
	 */
	public function getWait()
	{
		return $this->wait;
	}

	/**
	 * Set results
	 *
	 * @param string $results
	 *
	 * @return Test
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
}
