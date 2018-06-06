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
	 * @ORM\ManyToOne(targetEntity="caseStudy", inversedBy="days")
	 */
	private $caseStudy;

	/**
	 * @ORM\OneToMany(targetEntity="HotSpotInfo", mappedBy="day", cascade={"all"})
	 */
	private $hotspotsInfo;

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
		$this->hotspotsInfo = new ArrayCollection();
		$this->tests = new ArrayCollection();
		$this->medications = new ArrayCollection();
	}

	public function __toString()
	{
		$s = "";

		foreach ($this->hotspotsInfo as $spot) {
			$s .= sprintf("%s\n", $spot);
		}
		foreach ($this->tests as $result) {
			$s .= sprintf("%s\n", $result);
		}
		foreach ($this->medications as $result) {
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

    public function setCaseStudy(\AppBundle\Entity\CaseStudy $caseStudy = null)
    {
        $this->caseStudy = $caseStudy;

        return $this;
    }

    public function getCaseStudy()
    {
        return $this->caseStudy;
    }

    public function addTest(\AppBundle\Entity\TestResults $test)
    {
				if( !$this->tests->contains($test) ) {
					$test->setDay($this);
					$this->tests->add($test);
				}

				return $this;
    }

    public function removeTest(\AppBundle\Entity\TestResults $test)
    {
        $test->setDay(null);
        $this->tests->removeElement($test);

				return $this;
    }

    public function getTests()
    {
        return $this->tests;
    }

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

    public function addMedication(\AppBundle\Entity\MedicationResults $medication)
    {
				if( !$this->medications->contains($medication) ) {
					$medication->setDay($this);
					$this->medications->add($medication);
				}

				return $this;
    }

    public function removeMedication(\AppBundle\Entity\MedicationResults $medication)
    {
        $medication->setDay(null);
        $this->medications->removeElement($medication);

				return $this;
    }

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

    public function getMedications()
    {
        return $this->medications;
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
