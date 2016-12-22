<?php
// src/AppBundle/Entity/Day.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Days")
 */
class Day
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="array")
	 */
	private $hotspots;

	/**
	 * @ORM\Column(type="array")
	 */
	private $tests;

	/**
	 * @ORM\Column(type="array")
	 */
	private $medications;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $number;

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
	 * Set hotspots
	 *
	 * @param array $hotspots
	 *
	 * @return Day
	 */
	public function setHotspots($hotspots)
	{
		$this->hotspots = $hotspots;

		return $this;
	}

	/**
	 * Get hotspots
	 *
	 * @return array
	 */
	public function getHotspots()
	{
		return $this->hotspots;
	}

	/**
	 * Set tests
	 *
	 * @param array $tests
	 *
	 * @return Day
	 */
	public function setTests($tests)
	{
		$this->tests = $tests;

		return $this;
	}

	/**
	 * Get tests
	 *
	 * @return array
	 */
	public function getTests()
	{
		return $this->tests;
	}

	/**
	 * Set medications
	 *
	 * @param array $medications
	 *
	 * @return Day
	 */
	public function setMedications($medications)
	{
		$this->medications = $medications;

		return $this;
	}

	/**
	 * Get medications
	 *
	 * @return array
	 */
	public function getMedications()
	{
		return $this->medications;
	}

	/**
	 * Set number
	 *
	 * @param integer $number
	 *
	 * @return Day
	 */
	public function setNumber($number)
	{
		$this->number = $number;

		return $this;
	}

	/**
	 * Get number
	 *
	 * @return integer
	 */
	public function getNumber()
	{
		return $this->number;
	}
}
