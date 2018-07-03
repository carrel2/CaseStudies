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
	* @ORM\OneToMany(targetEntity="DiagnosticResults", mappedBy="userDay")
	*/
	private $tests;

	/**
	* @ORM\OneToMany(targetEntity="TherapeuticResults", mappedBy="userDay")
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
		$a = array("hotspotsInfo" => array(), "diagnostics" => array(), "therapeutics" => array(), "diagnosis" => "");

		foreach($this->hotspotsInfo as $spot)
		{
			$a["hotspotsInfo"][$spot->getHotspot()->getName()] = $spot->getInfo();
		}
		foreach ($this->tests as $test)
		{
			$a["diagnostics"][$test->getDiagnosticProcedure()->getName()] = $test->getResults();
		}
		foreach ($this->medications as $medication)
		{
			$a["therapeutics"][$medication->getTherapeuticProcedure()->getName()] = $medication->getResults();
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
		if( !$this->hotspotsInfo->contains($hotspotInfo) ) {
			$hotspotInfo->setUserDay($this);
			$this->hotspotsInfo->add($hotspotInfo);
		}

		return $this;
	}

	public function removeHotspotInfo(\AppBundle\Entity\HotSpotInfo $hotspotInfo)
	{
		$hotspotInfo->setUserDay(null);
		$this->hotspotsInfo->removeElement($hotspotInfo);

		return $this;
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

	public function addDiagnosticProcedure(\AppBundle\Entity\DiagnosticResults $test)
	{
		if( !$this->tests->contains($test) ) {
			$test->setUserDay($this);
			$this->tests->add($test);
		}

		return $this;
	}

	public function removeDiagnosticProcedure(\AppBundle\Entity\DiagnosticResults $test)
	{
		$test->setUserDay(null);
		$this->tests->removeElement($test);

		return $this;
	}

	public function removeDiagnostics()
	{
		foreach( $this->tests as $test ) {
			$this->removeDiagnosticProcedure($test);
		}

		return $this;
	}

	public function getDiagnostics()
	{
		return $this->tests;
	}

	public function addTherapeuticProcedure(\AppBundle\Entity\TherapeuticResults $medication)
	{
		if( !$this->medications->contains($medication) ) {
			$medication->setUserDay($this);
			$this->medications->add($medication);
		}

		return $this;
	}

	public function removeTherapeuticProcedure(\AppBundle\Entity\TherapeuticResults $medication)
	{
		$medication->setUserDay(null);
		$this->medications->removeElement($medication);

		return $this;
	}

	public function removeTherapeutics()
	{
		foreach( $this->medications as $medication ) {
			$this->removeTherapeuticProcedure($medication);
		}

		return $this;
	}

	public function getTherapeutics()
	{
		return $this->medications;
	}

    public function addHotspotsInfo(\AppBundle\Entity\HotSpotInfo $hotspotInfo)
    {
				if( !$this->hotspotsInfo->contains($hotspotInfo) ) {
					$hotspotInfo->setUserDay($this);
	        $this->hotspotsInfo->add($hotspotInfo);
				}

        return $this;
    }
}
