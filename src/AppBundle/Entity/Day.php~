<?php
// src/AppBundle/Entity/Day.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
	 * @ORM\ManyToOne(targetEntity="Session", inversedBy="days")
	 */
	private $session;

	/**
	 * @ORM\OneToMany(targetEntity="HotSpots", mappedBy="day", cascade={"persist", "remove"})
	 */
	private $hotspots;

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

	public function __construct()
	{
		$this->hotspots = new ArrayCollection();
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

    /**
     * Set session
     *
     * @param \AppBundle\Entity\Session $session
     *
     * @return Day
     */
    public function setSession(\AppBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \AppBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Remove hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     */
    public function removeHotspot(\AppBundle\Entity\HotSpots $hotspot)
    {
        $this->hotspots->removeElement($hotspot);
    }

    /**
     * Add hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     *
     * @return Day
     */
    public function addHotspot(\AppBundle\Entity\HotSpots $hotspot)
    {
        $this->hotspots[] = $hotspot;

        return $this;
    }

    /**
     * Get hotspots
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHotspots()
    {
        return $this->hotspots;
    }
}
