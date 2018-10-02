<?php
// src/AppBundle/Entity/Therapeutic.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Therapeutics")
 */
class TherapeuticProcedure extends AbstractProcedure
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
   * @ORM\Column(type="decimal", scale=2)
   */
  protected $dosage = 0;

  /**
   * @ORM\Column(type="integer")
   */
  protected $dosageInterval = 0;

  /**
   * @ORM\Column(type="decimal", scale=2)
   */
  protected $concentration = 1;

	/**
	 * @ORM\Column(type="string", length=10)
	 */
	protected $costPerUnit = "0";

	/**
  * @ORM\ManyToOne(targetEntity="Category", inversedBy="therapeutics")
  */
  private $category;

	/**
	 * @ORM\OneToMany(targetEntity="TherapeuticResults", mappedBy="therapeuticProcedure")
	 */
	private $results;

	public function __construct()
	{
		$this->results = new ArrayCollection();
	}

	public function getId() {
		return $this->id;
	}

	public function setDosage($dosage) {
    $this->dosage = $dosage;

    return $this;
  }

  public function getDosage() {
    return $this->dosage;
  }

  public function setDosageInterval($dosageInterval) {
    $this->dosageInterval = $dosageInterval;

    return $this;
  }

  public function getDosageInterval() {
    return $this->dosageInterval;
  }

  public function setConcentration($concentration) {
    $this->concentration = $concentration;

    return $this;
  }

  public function getConcentration() {
    return $this->concentration;
  }

	public function setCostPerUnit($costPerUnit)
  {
    $this->costPerUnit = $costPerUnit;

    return $this;
  }

  public function getCostPerUnit()
  {
    return $this->costPerUnit;
  }

  public function getPerDayCost($weight = null) {
		if( $this->cost ) {
			return $this->cost;
		}

		if( $this->concentration == 0 ) {
			return 0;
		}

		return ( $this->dosage * $this->dosageInterval / $this->concentration ) * $this->costPerUnit * ($weight ? $weight : 1);
  }

	public function setCategory($category) {
		$this->category = $category;

		return $this;
	}

	public function getCategory() {
		return $this->category;
	}

  public function addResult(\AppBundle\Entity\TherapeuticResults $result)
  {
		if( !$this->results->contains($result) ) {
			$result->setTherapeuticProcedure($this);
			$this->results->add($result);
		}

    return $this;
  }

  public function removeResult(\AppBundle\Entity\TherapeuticResults $result)
  {
		$result->setTherapeuticProcedure(null);
    $this->results->removeElement($result);

		return $this;
  }

  public function getResults()
  {
    return $this->results;
  }

	public function getResultsByCase(\AppBundle\Entity\CaseStudy $caseStudy)
	{
		$collection = $this->results->filter(function($r) use ($caseStudy) {
			return $r->getDay()->getCaseStudy()->getId() == $caseStudy->getId();
		});

		return $collection->isEmpty() ? null : $collection->first();
	}
}
