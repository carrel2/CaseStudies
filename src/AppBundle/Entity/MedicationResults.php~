<?php
// src/AppBundle/Entity/MedicationResults.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MedicationResults")
 */
class MedicationResults
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="CaseStudy", inversedBy="medicationResults")
	 * @ORM\JoinColumn(name="case_id", referencedColumnName="id")
	 */
	private $caseStudy;

	/**
	 * @ORM\ManyToOne(targetEntity="Medication", inversedBy="results")
	 */
	private $medication;

	/**
	 * @ORM\Column(type="text")
	 */
	private $results;

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
     * Set results
     *
     * @param string $results
     *
     * @return MedicationResults
     */
    public function setResults($results)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * Get results
     *
     * @return string
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set caseStudy
     *
     * @param \AppBundle\Entity\CaseStudy $caseStudy
     *
     * @return MedicationResults
     */
    public function setCaseStudy(\AppBundle\Entity\CaseStudy $caseStudy = null)
    {
        $this->caseStudy = $caseStudy;

        return $this;
    }

    /**
     * Get caseStudy
     *
     * @return \AppBundle\Entity\CaseStudy
     */
    public function getCaseStudy()
    {
        return $this->caseStudy;
    }

    /**
     * Set medication
     *
     * @param \AppBundle\Entity\Medication $medication
     *
     * @return MedicationResults
     */
    public function setMedication(\AppBundle\Entity\Medication $medication = null)
    {
        $this->medication = $medication;

        return $this;
    }

    /**
     * Get medication
     *
     * @return \AppBundle\Entity\Medication
     */
    public function getMedication()
    {
        return $this->medication;
    }
}
