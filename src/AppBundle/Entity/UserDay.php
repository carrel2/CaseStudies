<?php
// src/AppBundle/Entity/UserDay.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User Day class
 *
 * Contains information relevant to the user to be compared to the original case study
 *
 * @ORM\Entity
 * @ORM\Table(name="UserDays")
 */
class UserDay
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="days")
	 */
	private $user;

	/**
	 * @ORM\OneToMany(targetEntity="HotSpots", mappedBy="userDay")
	 */
	private $hotspots;

	/**
	 * @ORM\OneToMany(targetEntity="TestResults", mappedBy="userDay")
	 */
	private $tests;

	/**
	 * @ORM\OneToMany(targetEntity="MedicationResults", mappedBy="userDay")
	 */
	private $medications;

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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserDay
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     *
     * @return UserDay
     */
    public function addHotspot(\AppBundle\Entity\HotSpots $hotspot)
    {
        $hotspot->setUserDay($this);
        $this->hotspots[] = $hotspot;

        return $this;
    }

    /**
     * Remove hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     */
    public function removeHotspot(\AppBundle\Entity\HotSpots $hotspot)
    {
        $hotspot->setUserDay(null);
        $this->hotspots->removeElement($hotspot);
    }

    /**
     * Remove all hotspots
     *
     * @return UserDay
     */
    public function removeHotspots()
    {
        foreach( $this->hotspots as $hotspot ) {
            $this->removeHotspot($hotspot);
        }

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
     * Add test
     *
     * @param \AppBundle\Entity\TestResults $test
     *
     * @return UserDay
     */
    public function addTest(\AppBundle\Entity\TestResults $test)
    {
        $test->setUserDay($this);
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
        $test->setUserDay(null);
        $this->tests->removeElement($test);
    }

    /**
     * Remove all tests
     *
     * @return UserDay
     */
    public function removeTests()
    {
        foreach( $this->tests as $test ) {
            $this->removeTest($test);
        }

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
     * Add medication
     *
     * @param \AppBundle\Entity\MedicationResults $medication
     *
     * @return UserDay
     */
    public function addMedication(\AppBundle\Entity\MedicationResults $medication)
    {
        $medication->setUserDay($this);
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
        $medication->setUserDay(null);
        $this->medications->removeElement($medication);
    }

    /**
     * Remove all medications
     *
     * @return UserDay
     */
    public function removeMedications()
    {
        foreach( $this->medications as $medication ) {
            $this->removeMedication($medication);
        }

        return $this;
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
