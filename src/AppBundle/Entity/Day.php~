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
	 * @ORM\ManyToOne(targetEntity="caseStudy", inversedBy="days")
	 */
	private $caseStudy;

	/**
	 * @ORM\OneToMany(targetEntity="HotSpots", mappedBy="day", cascade={"persist", "remove"})
	 */
	private $hotspots;

	/**
	 * @ORM\OneToMany(targetEntity="TestResults", mappedBy="day", cascade={"persist", "remove"})
	 */
	private $tests;

	/**
	 * @ORM\OneToMany(targetEntity="MedicationResults", mappedBy="day", cascade={"persist", "remove"})
	 */
	private $medications;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $number;

	public function __construct()
	{
		$this->hotspots = new ArrayCollection();
		$this->tests = new ArrayCollection();
		$this->medications = new ArrayCollection();
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

    /**
     * Set caseStudy
     *
     * @param \AppBundle\Entity\caseStudy $caseStudy
     *
     * @return Day
     */
    public function setCaseStudy(\AppBundle\Entity\caseStudy $caseStudy = null)
    {
        $this->caseStudy = $caseStudy;

        return $this;
    }

    /**
     * Get caseStudy
     *
     * @return \AppBundle\Entity\caseStudy
     */
    public function getCaseStudy()
    {
        return $this->caseStudy;
    }

    /**
     * Add test
     *
     * @param \AppBundle\Entity\TestResults $test
     *
     * @return Day
     */
    public function addTest(\AppBundle\Entity\TestResults $test)
    {
        $this->tests[] = $test;

        return $this;
    }

    /**
     * Remove test
     *
     * @param \AppBundle\Entity\TestResults $test
     */
    public function removeTest(\AppBundle\Entity\TestResults $test)
    {
        $this->tests->removeElement($test);
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * Add medication
     *
     * @param \AppBundle\Entity\MedicationResults $medication
     *
     * @return Day
     */
    public function addMedication(\AppBundle\Entity\MedicationResults $medication)
    {
        $this->medications[] = $medication;

        return $this;
    }

    /**
     * Remove medication
     *
     * @param \AppBundle\Entity\MedicationResults $medication
     */
    public function removeMedication(\AppBundle\Entity\MedicationResults $medication)
    {
        $this->medications->removeElement($medication);
    }

    /**
     * Get medications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedications()
    {
        return $this->medications;
    }
}
