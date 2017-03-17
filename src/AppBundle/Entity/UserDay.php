<?php
// src/AppBundle/Entity/UserDay.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
* User Day class
*
* Contains information relevant to the User to be compared to the original CaseStudy
*
* @see User::class
* @see CaseStudy::class
*
* @ORM\Entity
* @ORM\Table(name="UserDays")
*/
class UserDay
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
	* Associated User
	*
	* @var ArrayCollection
	*
	* @see User::class
	* @see ArrayCollection::class
	*
	* @ORM\ManyToOne(targetEntity="User", inversedBy="days")
	*/
	private $user;

	/**
	* ArrayCollection of HotSpots
	*
	* @var ArrayCollection
	*
	* @see ArrayCollection::class
	* @see HotSpots::class
	*
	* @ORM\OneToMany(targetEntity="HotSpots", mappedBy="userDay")
	*/
	private $hotspots;

	/**
	* ArrayCollection of TestResults
	*
	* @var ArrayCollection
	*
	* @see ArrayCollection::class
	* @see TestResults::class
	*
	* @ORM\OneToMany(targetEntity="TestResults", mappedBy="userDay")
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
	* @ORM\OneToMany(targetEntity="MedicationResults", mappedBy="userDay")
	*/
	private $medications;

	/**
	* The associated Results object
	*
	* @var Results
	*
	* @see Results::class
	*
	* @ORM\ManyToOne(targetEntity="Results", inversedBy="userDays")
	*/
	private $results;

	/**
	* Constructor function
	*
	* Initializes $hotspots, $tests, and $medications as ArrayCollection
	*
	* @see ArrayCollection::class
	*/
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
	* @see User::class
	*
	* @return self
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
	* @see HotSpots::class
	*
	* @return self
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
	*
	* @see HotSpots::class
	*/
	public function removeHotspot(\AppBundle\Entity\HotSpots $hotspot)
	{
		$hotspot->setUserDay(null);
		$this->hotspots->removeElement($hotspot);
	}

	/**
	* Remove all hotspots
	*
	* @return self
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
	* @see TestResults::class
	*
	* @return self
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
	*
	* @see TestResults::class
	*
	* @return self
	*/
	public function removeTest(\AppBundle\Entity\TestResults $test)
	{
		$test->setUserDay(null);
		$this->tests->removeElement($test);

		return $this;
	}

	/**
	* Remove all tests
	*
	* @return self
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
	* @see MedicationResults::class
	*
	* @return self
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
	*
	* @see MedicationResults::class
	*
	* @return self
	*/
	public function removeMedication(\AppBundle\Entity\MedicationResults $medication)
	{
		$medication->setUserDay(null);
		$this->medications->removeElement($medication);

		return $this;
	}

	/**
	* Remove all medications
	*
	* @return self
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

    /**
     * Set results
     *
     * @param \AppBundle\Entity\Results $results
     *
     * @return UserDay
     */
    public function setResults(\AppBundle\Entity\Results $results = null)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * Get results
     *
     * @return \AppBundle\Entity\Results
     */
    public function getResults()
    {
        return $this->results;
    }
}
