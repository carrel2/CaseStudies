<?php
// src/AppBundle/Entity/Diagnostic.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Diagnostics")
 */
class DiagnosticProcedure extends AbstractProcedure
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\OneToMany(targetEntity="DiagnosticResults", mappedBy="test")
	 */
	private $results;

	public function __construct(array $array = null)
	{
		parent::__construct($array);

		$this->results = new ArrayCollection();
	}

  public function getId()
  {
    return $this->id;
  }

  public function addResult(\AppBundle\Entity\DiagnosticResults $result)
  {
		if( !$this->results->contains($result) ) {
			$result->setDiagnosticProcedure($this);
      $this->results->add($result);
		}
    return $this;
  }

  public function removeResult(\AppBundle\Entity\DiagnosticResults $result)
  {
		$result->setDiagnosticProcedure(null);
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
