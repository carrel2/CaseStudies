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
	private $diagnosticResults;

	/**
	* @ORM\OneToMany(targetEntity="TherapeuticResults", mappedBy="userDay")
	*/
	private $therapeuticResults;

	public function __construct()
	{
		$this->hotspotInfo = new ArrayCollection();
		$this->diagnosticResults = new ArrayCollection();
		$this->therapeuticResults = new ArrayCollection();
	}

	public function toArray()
	{
		$a = array("hotspotsInfo" => array(), "diagnostics" => array(), "therapeutics" => array(), "diagnosis" => "");

		foreach($this->hotspotsInfo as $spot)
		{
			$a["hotspotsInfo"][$spot->getHotspot()->getName()] = $spot->getInfo();
		}
		foreach ($this->diagnosticResults as $dr)
		{
			$a["diagnostics"][$dr->getDiagnosticProcedure()->getName()] = $dr->getResults();
		}
		foreach ($this->therapeuticResults as $tr)
		{
			$a["therapeutics"][$tr->getTherapeuticProcedure()->getName()] = $tr->getResults();
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

	public function addDiagnosticProcedure(\AppBundle\Entity\DiagnosticResults $dr)
	{
		if( !$this->diagnosticResults->contains($dr) ) {
			$dr->setUserDay($this);
			$this->diagnosticResults->add($dr);
		}

		return $this;
	}

	public function removeDiagnosticProcedure(\AppBundle\Entity\DiagnosticResults $dr)
	{
		$dr->setUserDay(null);
		$this->diagnosticResults->removeElement($dr);

		return $this;
	}

	public function removeDiagnosticResults()
	{
		foreach( $this->diagnosticResults as $dr ) {
			$this->removeDiagnosticProcedure($dr);
		}

		return $this;
	}

	public function getDiagnosticResults()
	{
		return $this->diagnosticResults;
	}

	public function addTherapeuticProcedure(\AppBundle\Entity\TherapeuticResults $tr)
	{
		if( !$this->therapeuticResults->contains($tr) ) {
			$tr->setUserDay($this);
			$this->therapeuticResults->add($tr);
		}

		return $this;
	}

	public function removeTherapeuticProcedure(\AppBundle\Entity\TherapeuticResults $tr)
	{
		$tr->setUserDay(null);
		$this->therapeuticResults->removeElement($tr);

		return $this;
	}

	public function removeTherapeuticResults()
	{
		foreach( $this->therapeuticResults as $tr ) {
			$this->removeTherapeuticProcedure($tr);
		}

		return $this;
	}

	public function getTherapeuticResults()
	{
		return $this->therapeuticResults;
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
