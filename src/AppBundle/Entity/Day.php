<?php
// src/AppBundle/Entity/Day.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Day class
 *
 * Contains information about HotSpots, TestResults, and MedicationResults for a single Day in a CaseStudy
 *
 * @see HotSpots::class
 * @see TestResults::class
 * @see MedicationResults::class
 * @see CaseStudy::class
 *
 * @ORM\Entity
 * @ORM\Table(name="Days")
 */
class Day
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
	 * Associated CaseStudy
	 *
	 * @var CaseStudy
	 *
	 * @see CaseStudy::class
	 *
	 * @ORM\ManyToOne(targetEntity="caseStudy", inversedBy="days")
	 */
	private $caseStudy;

	/**
	 * ArrayCollection of HotSpots objects
	 *
	 * @var ArrayCollection
	 *
	 * @see ArrayCollection::class
	 * @see HotSpots::class
	 *
	 * @ORM\OneToMany(targetEntity="HotSpots", mappedBy="day", cascade={"persist", "remove"})
	 */
	private $hotspots;

	/**
	 * ArrayCollection of TestResults objects
	 *
	 * @var ArrayCollection
	 *
	 * @see ArrayCollection::class
	 * @see TestResults::class
	 *
	 * @ORM\OneToMany(targetEntity="TestResults", mappedBy="day", cascade={"persist", "remove"})
	 */
	private $tests;

	/**
	 * ArrayCollection of MedicationResults
	 *
	 * @var ArrayCollection
	 *
	 * @see ArrayCollection::class
	 * @see MedicationResults::class
	 *
	 * @ORM\OneToMany(targetEntity="MedicationResults", mappedBy="day", cascade={"persist", "remove"})
	 */
	private $medications;

	/**
	 * Constructor function
	 *
	 * Initializes $users, $hotspots, $tests, and $medications as ArrayCollection
	 *
	 * @see ArrayCollection::class
	 */
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
		 * Removes $hotspot from $hotspots and removes association between $this and $hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
		 *
		 * @return self
     */
    public function removeHotspot(\AppBundle\Entity\HotSpots $hotspot)
    {
        $hotspot->setDay(null);
        $this->hotspots->removeElement($hotspot);

				return $this;
    }

    /**
     * Add hotspot
		 *
		 * Appends $hotpot to $hotspots and associates $this as Day for $hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     *
     * @return self
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
		 * Associates $caseStudy as the CaseStudy for $this
     *
     * @param \AppBundle\Entity\caseStudy $caseStudy
     *
     * @return self
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
		 * Appends $test to $tests and associates $this as Day for $test
     *
     * @param \AppBundle\Entity\TestResults $test
     *
     * @return self
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
		 * Removes $test from $tests and removes association between $this and $test
     *
     * @param \AppBundle\Entity\TestResults $test
		 *
		 * @return self
     */
    public function removeTest(\AppBundle\Entity\TestResults $test)
    {
        $test->setDay(null);
        $this->tests->removeElement($test);

				return $this;
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
		 * @param Test $test Test to get results for
		 *
     * @return \AppBundle\Entity\TestResults Null if no **TestResults** found
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
		 * Appends $medication to $medications and associates $this as Day for $medication
     *
     * @param \AppBundle\Entity\MedicationResults $medication
     *
     * @return self
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
		 * Removes $medication and removes association between $this and $medication
     *
     * @param \AppBundle\Entity\MedicationResults $medication
		 *
		 * @return self
     */
    public function removeMedication(\AppBundle\Entity\MedicationResults $medication)
    {
        $medication->setDay(null);
        $this->medications->removeElement($medication);

				return $this;
    }

    /**
     * Get result by medication
		 *
		 * @param Medication $medication Medication to get results for
     *
     * @return \AppBundle\Entity\MedicationResults Null if no **MedicationResults** found
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
