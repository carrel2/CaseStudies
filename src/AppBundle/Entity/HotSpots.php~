<?php
// src/AppBundle/Entity/HotSpots.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Hotspots")
 */
class HotSpots
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="CaseStudy", inversedBy="hotspots")
	 * @ORM\JoinColumn(name="case_id", referencedColumnName="id")
	 */
	private $caseStudy;

	/**
	 * @ORM\Column(type="string", length=40)
	 */
	private $name;

	/**
	 * @ORM\Column(type="text")
	 */
	private $info;

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
     * Set name
     *
     * @param string $name
     *
     * @return HotSpots
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return HotSpots
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set case
     *
     * @param integer $case
     *
     * @return HotSpots
     */
    public function setCaseId($case)
    {
        $this->case = $case;

        return $this;
    }

    /**
     * Get case
     *
     * @return integer
     */
    public function getCaseId()
    {
        return $this->case;
    }

    /**
     * Set caseStudy
     *
     * @param \AppBundle\Entity\CaseStudy $caseStudy
     *
     * @return HotSpots
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
}
