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
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @ORM\Column(type="boolean")
	 */
	private $skip;

	/**
	 * @ORM\ManyToOne(targetEntity="CaseStudy", inversedBy="days")
	 */
	private $caseStudy;

	/**
	 * @ORM\OneToMany(targetEntity="HotSpotInfo", mappedBy="day", cascade={"all"})
	 */
	private $hotspotsInfo;

	/**
	 * @ORM\OneToMany(targetEntity="DiagnosticResults", mappedBy="day", cascade={"persist", "remove"})
	 */
	private $diagnosticResults;

	/**
	 * @ORM\OneToMany(targetEntity="TherapeuticResults", mappedBy="day", cascade={"persist", "remove"})
	 */
	private $therapeuticResults;

	public function __construct()
	{
		$this->hotspotsInfo = new ArrayCollection();
		$this->diagnosticResults = new ArrayCollection();
		$this->therapeuticResults = new ArrayCollection();
	}

	public function __toString()
	{
		$s = "";

		foreach ($this->hotspotsInfo as $spot) {
			$s .= sprintf("%s\n", $spot);
		}
		foreach ($this->diagnosticResults as $result) {
			$s .= sprintf("%s\n", $result);
		}
		foreach ($this->therapeuticResults as $result) {
			$s .= sprintf("%s\n", $result);
		}

		return $s;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	public function setSkip($bool) {
		$this->skip = $bool;

		return $this;
	}

	public function getSkip() {
		return $this->skip;
	}

    public function setCaseStudy(\AppBundle\Entity\CaseStudy $caseStudy = null)
    {
        $this->caseStudy = $caseStudy;

        return $this;
    }

    public function getCaseStudy()
    {
        return $this->caseStudy;
    }

    public function addDiagnosticResult(\AppBundle\Entity\DiagnosticResults $dr)
    {
				if( !$this->diagnosticResults->contains($dr) ) {
					$dr->setDay($this);
					$this->diagnosticResults->add($dr);
				}

				return $this;
    }

    public function removeDiagnosticResult(\AppBundle\Entity\DiagnosticResults $dr)
    {
        $test->setDay(null);
        $this->diagnosticResults->removeElement($dr);

				return $this;
    }

    public function getDiagnosticResults()
    {
        return $this->diagnosticResults;
    }

    public function getResultByDiagnosticProcedure(\AppBundle\Entity\DiagnosticProcedure $dp)
    {
        foreach( $this->diagnosticResults as $results )
        {
            if( $results->getDiagnosticProcedure()->getId() === $dp->getId() )
            {
                return $results;
            }
        }

        return null;
    }

    public function addTherapeuticResult(\AppBundle\Entity\TherapeuticResults $tr)
    {
				if( !$this->therapeuticResults->contains($tr) ) {
					$tr->setDay($this);
					$this->therapeuticResults->add($tr);
				}

				return $this;
    }

    public function removeTherapeuticResult(\AppBundle\Entity\TherapeuticResults $tr)
    {
        $tr->setDay(null);
        $this->therapeuticResults->removeElement($tr);

				return $this;
    }

    public function getResultByTherapeuticProcedure(\AppBundle\Entity\TherapeuticProcedure $tr)
    {
        foreach( $this->therapeuticResults as $results )
        {
            if( $results->getTherapeuticProcedure()->getId() === $tr->getId() )
            {
                return $results;
            }
				}

        return null;
    }

    public function getTherapeuticResults()
    {
        return $this->therapeuticResults;
    }

    public function addHotspotsInfo(\AppBundle\Entity\HotSpotInfo $hotspotInfo)
    {
				if( !$this->hotspotsInfo->contains($hotspotInfo) ) {
					$hotspotInfo->setDay($this);
					$this->hotspotsInfo->add($hotspotInfo);
				}

				return $this;
    }

    public function removeHotspotsInfo(\AppBundle\Entity\HotSpotInfo $hotspotInfo)
    {
				$hotspotInfo->setDay(null);
        $this->hotspotsInfo->removeElement($hotspotInfo);

				return $this;
    }

    public function getHotspotsInfo()
    {
        return $this->hotspotsInfo;
    }

		public function getInfoByHotspot(\AppBundle\Entity\HotSpot $hotspot)
		{
			foreach ( $this->hotspotsInfo as $info ) {
				if( $info->getHotspot()->getId() === $hotspot->getId() )
				{
					return $info;
				}
			}

			return null;
		}
}
