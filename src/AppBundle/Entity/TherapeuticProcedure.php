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
