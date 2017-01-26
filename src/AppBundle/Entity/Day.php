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
	private $hotspots = array();

	/**
	 * @ORM\Column(type="array")
	 */
	private $tests = array();

	/**
	 * @ORM\Column(type="array")
	 */
	private $medications = array();

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
	 * Add hotspot
	 *
	 * @param integer $hotspot
	 *
	 * @return Day
	 */
	public function addHotspot($hotspot)
	{
		array_push($this->hotspots, $hotspot);

		return $this;
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
	 * Add test
	 *
	 * @param integer $test
	 *
	 * @return Day
	 */
	public function addTest($test)
	{
		array_push($this->tests, $test);

		return $this;
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
	 * Add medication
	 *
	 * @param integer $medication
	 *
	 * @return Day
	 */
	public function addMedication($medication)
	{
		array_push($this->medications, $medication);

		return $this;
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
