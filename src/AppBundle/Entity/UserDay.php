<?php
// src/AppBundle/Entity/UserDay.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
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
	* @ORM\OneToMany(targetEntity="HotSpotInfo", mappedBy="userDay", cascade={"persist"})
	*/
	private $hotspotsInfo;

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

	public function getId()
	{
		return $this->id;
	}

	public function setUser(\AppBundle\Entity\User $user = null)
	{
		$this->user = $user;

		return $this;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function addHotspotInfo(\AppBundle\Entity\HotSpotInfo $hotspotInfo)
	{
		$hotspotInfo->setUserDay($this);
		$this->hotspotsInfo[] = $hotspotInfo;

		return $this;
	}

	public function removeHotspotInfo(\AppBundle\Entity\HotSpotInfo $hotspotInfo)
	{
		$hotspotInfo->setUserDay(null);
		$this->hotspotsInfo->removeElement($hotspotInfo);
	}

	public function removeHotspotsInfo()
	{
		foreach( $this->hotspotsInfo as $info ) {
			$this->removeHotspotInfo($info);
		}

		return $this;
	}

	public function getHotspotsInfo()
	{
		return $this->hotspotsInfo;
	}

	public function addTest(\AppBundle\Entity\TestResults $test)
	{
		$test->setUserDay($this);
		$this->tests[] = $test;

		return $this;
	}

	public function removeTest(\AppBundle\Entity\TestResults $test)
	{
		$test->setUserDay(null);
		$this->tests->removeElement($test);

		return $this;
	}

	public function removeTests()
	{
		foreach( $this->tests as $test ) {
			$this->removeTest($test);
		}

		return $this;
	}

	public function getTests()
	{
		return $this->tests;
	}

	public function addMedication(\AppBundle\Entity\MedicationResults $medication)
	{
		$medication->setUserDay($this);
		$this->medications[] = $medication;

		return $this;
	}

	public function removeMedication(\AppBundle\Entity\MedicationResults $medication)
	{
		$medication->setUserDay(null);
		$this->medications->removeElement($medication);

		return $this;
	}

	public function removeMedications()
	{
		foreach( $this->medications as $medication ) {
			$this->removeMedication($medication);
		}

		return $this;
	}

	public function getMedications()
	{
		return $this->medications;
	}

    public function addHotspotsInfo(\AppBundle\Entity\HotSpotInfo $hotspotsInfo)
    {
        $this->hotspotsInfo[] = $hotspotsInfo;

        return $this;
    }
}
