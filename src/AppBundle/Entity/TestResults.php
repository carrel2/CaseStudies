<?php
// src/AppBundle/Entity/TestResults.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="TestResults")
 */
class TestResults
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="CaseStudy", inversedBy="testResults")
	 * @ORM\JoinColumn(name="case_id", referencedColumnName="id")
	 */
	private $caseStudy;

	/**
	 * @ORM\ManyToOne(targetEntity="Test", inversedBy="results")
	 */
	private $test;

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
     * @return TestResults
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
     * @return TestResults
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
     * Set test
     *
     * @param \AppBundle\Entity\Test $test
     *
     * @return TestResults
     */
    public function setTest(\AppBundle\Entity\Test $test = null)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \AppBundle\Entity\Test
     */
    public function getTest()
    {
        return $this->test;
    }
}
