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
* @see 'AppBundle\Entity\User'
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
	* @see 'AppBundle\Entity\User'
	* @see ArrayCollection::class
	*
	* @ORM\ManyToOne(targetEntity="User", inversedBy="days")
	*/
	private $user;

	/**
	* ArrayCollection of HotSpotInfo
	*
	* @var ArrayCollection
	*
	* @see ArrayCollection::class
	* @see 'AppBundle\Entity\HotSpotInfo'
	*
	* @ORM\OneToMany(targetEntity="HotSpotInfo", mappedBy="userDay", cascade={"persist"})
	*/
	private $hotspotsInfo;

	/**
	* ArrayCollection of TestResults
	*
	* @var ArrayCollection
	*
	* @see ArrayCollection::class
	* @see 'AppBundle\Entity\TestResults'
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
	* @see 'AppBundle\Entity\MedicationResults'
	*
	* @ORM\OneToMany(targetEntity="MedicationResults", mappedBy="userDay")
	*/
	private $medications;

	/**
	* Constructor function
	*
	* Initializes $hotspotInfo, $tests, and $medications as ArrayCollection
	*
	* @see ArrayCollection::class
	*/
	public function __construct()
	{
		$this->hotspotInfo = new ArrayCollection();
		$this->tests = new ArrayCollection();
		$this->medications = new ArrayCollection();
	}

	public function toArray()
	{
		$a = array("hotspotsInfo" => array(), "diagnostics" => array(), "therapeutics" => array());

		foreach($this->hotspotsInfo as $spot)
		{
			$a["hotspotsInfo"][$spot->getHotspot()->getName()] = $spot->getInfo();
		}
		foreach ($this->tests as $test)
		{
			$a["diagnostics"][$test->getTest()->getName()] = $test->getResults();
		}
		foreach ($this->medications as $medication)
		{
			$a["therapeutics"][$medication->getMedication()->getName()] = $medication->getResults();
		}

		return $a;
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
	* @see 'AppBundle\Entity\User'
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
	* Add hotspotInfo
	*
	* @param \AppBundle\Entity\HotSpotInfo $hotspotsInfo
	*
	* @see 'AppBundle\Entity\HotSpotInfo'
	*
	* @return self
	*/
	public function addHotspotInfo(\AppBundle\Entity\HotSpotInfo $hotspotInfo)
	{
		$hotspotInfo->setUserDay($this);
		$this->hotspotsInfo[] = $hotspotInfo;

		return $this;
	}

	/**
	* Remove hotspotInfo
	*
	* @param \AppBundle\Entity\HotSpotInfo $hotspotInfo
	*
	* @see 'AppBundle\Entity\HotSpotInfo'
	*/
	public function removeHotspotInfo(\AppBundle\Entity\HotSpotInfo $hotspotInfo)
	{
		$hotspotInfo->setUserDay(null);
		$this->hotspotsInfo->removeElement($hotspotInfo);
	}

	/**
	* Remove all hotspotsInfo
	*
	* @return self
	*/
	public function removeHotspotsInfo()
	{
		foreach( $this->hotspotsInfo as $info ) {
			$this->removeHotspotInfo($info);
		}

		return $this;
	}

	/**
	* Get hotspotsInfo
	*
	* @return \Doctrine\Common\Collections\Collection
	*/
	public function getHotspotsInfo()
	{
		return $this->hotspotsInfo;
	}

	/**
	* Add test
	*
	* @param \AppBundle\Entity\TestResults $test
	*
	* @see 'AppBundle\Entity\TestResults'
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
	* @see 'AppBundle\Entity\TestResults'
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
	* @see 'AppBundle\Entity\MedicationResults'
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
	* @see 'AppBundle\Entity\MedicationResults'
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
     * Add hotspotsInfo
     *
     * @param \AppBundle\Entity\HotSpotInfo $hotspotsInfo
     *
     * @return UserDay
     */
    public function addHotspotsInfo(\AppBundle\Entity\HotSpotInfo $hotspotsInfo)
    {
        $this->hotspotsInfo[] = $hotspotsInfo;

        return $this;
    }
}
