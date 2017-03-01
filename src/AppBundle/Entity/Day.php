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

	public function __construct()
	{
		$this->users = new ArrayCollection();
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
     * Remove hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     */
    public function removeHotspot(\AppBundle\Entity\HotSpots $hotspot)
    {
        $hotspot->setDay(null);
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
	$hotspot->setDay($this);
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
    public function setCaseStudy(\AppBundle\Entity\CaseStudy $caseStudy = null)
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
        $test->setDay($this);
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
        $test->setDay(null);
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
     * Get result by test
     *
     * @return \AppBundle\Entity\TestResults
     */
    public function getResultByTest(\AppBundle\Entity\Test $test)
    {
        foreach( $this->tests as $results )
        {
            if( $results->getTest()->getId() === $test->getId() )
            {
                return $results;
            }
        }

        return null;
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
        $medication->setDay($this);
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
        $medication->setDay(null);
        $this->medications->removeElement($medication);
    }

    /**
     * Get result by medication
     *
     * @return \AppBundle\Entity\MedicationResults
     */
    public function getResultByMedication(\AppBundle\Entity\Medication $medication)
    {
        foreach( $this->medications as $results )
        {
            if( $results->getMedication()->getId() === $medication->getId() )
            {
                return $results;
            }
	}

        return null;
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
