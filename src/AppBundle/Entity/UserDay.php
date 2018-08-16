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
	 * @ORM\Column(type="array")
	 */
	private $emptyHotspotsInfo = array();

	/**
	* @ORM\OneToMany(targetEntity="DiagnosticResults", mappedBy="userDay")
	*/
	private $diagnosticResults;

	/**
	 * @ORM\Column(type="array")
	 */
	private $emptyDiagnosticResults = array();

	/**
	* @ORM\OneToMany(targetEntity="TherapeuticResults", mappedBy="userDay")
	*/
	private $therapeuticResults;

	/**
	 * @ORM\Column(type="array")
	 */
	private $emptyTherapeuticResults = array();

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $differentials;

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
			$did = $dr->getId();
			$dp = $dr->getDiagnosticProcedure();

			$a["diagnostics"][$did]["name"] = $dp->getName();
			$a["diagnostics"][$did]["results"] = $dr->getResults();
			$a["diagnostics"][$did]["cost"] = $dp->getCost();
		}
		foreach ($this->therapeuticResults as $tr)
		{
			$tid = $tr->getId();
			$tp = $tr->getTherapeuticProcedure();

			$a["therapeutics"][$tid]["name"] = $tp->getName();
			$a["therapeutics"][$tid]["results"] = $tr->getResults();
			$a["therapeutics"][$tid]["cost"] = $tp->getPerDayCost();
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

	public function addEmptyHotspotsInfo($emptyHotspotInfo) {
		$this->emptyHotspotsInfo[] = $emptyHotspotInfo;

		return $this;
	}

	public function getEmptyHotspotsInfo() {
		return $this->emptyHotspotsInfo;
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

	public function addEmptyDiagnosticResults($emptyDiagnosticResult) {
		if( !in_array($emptyDiagnosticResult, $this->emptyDiagnosticResults) ) {
			$this->emptyDiagnosticResults[] = $emptyDiagnosticResult;
		}

		return $this;
	}

	public function getEmptyDiagnosticResults() {
		return $this->emptyDiagnosticResults;
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

	public function addEmptyTherapeuticResults($emptyTherapeuticResult) {
		if( !in_array($emptyTherapeuticResult, $this->emptyTherapeuticResults) ) {
			$this->emptyTherapeuticResults[] = $emptyTherapeuticResult;
		}

		return $this;
	}

	public function getEmptyTherapeuticResults() {
		return $this->emptyTherapeuticResults;
	}

	public function setDifferentials($differentials) {
		$this->differentials = $differentials;

		return $this;
	}

	public function getDifferentials() {
		return $this->differentials;
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
