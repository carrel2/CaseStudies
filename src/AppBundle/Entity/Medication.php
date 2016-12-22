<?php
// src/AppBundle/Entity/Medication.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Medications")
 */
class Medication
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
	private $case;

	/**
	 * @ORM\Column(type="string", length=40)
	 */
	private $name;

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
	 * @return Medication
	 */
	public function setCase($case)
	{
		$this->case = $case;

		return $this;
	}

	/**
	 * Get case
	 *
	 * @return integer
	 */
	public function getCase()
	{
		return $this->case;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Medication
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
	 * Set results
	 *
	 * @param string $results
	 *
	 * @return Medication
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
