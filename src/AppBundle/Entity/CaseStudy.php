<?php
// src/AppBundle/Entity/CaseStudy.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Cases")
 */
class CaseStudy
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=40)
	 */
	private $title;

	/**
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @ORM\OneToMany(targetEntity="HotSpots", mappedBy="caseStudy")
	 */
	private $hotspots;

	/**
	 * @ORM\OneToMany(targetEntity="Session", mappedBy="caseStudy")
	 */
	private $sessions;

    public function __construct()
    {
        $this->hotspots = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getCase()
    {
        return $this->title;
    }

    public function setCase($title)
    {
        $this->title = $title;

        return $this;
    }

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
     * Set title
     *
     * @param string $name
     *
     * @return CaseStudy
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CaseStudy
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     *
     * @return CaseStudy
     */
    public function addHotspot(\AppBundle\Entity\HotSpots $hotspot)
    {
        $this->hotspots[] = $hotspot;

        return $this;
    }

    /**
     * Remove hotspot
     *
     * @param \AppBundle\Entity\HotSpots $hotspot
     */
    public function removeHotspot(\AppBundle\Entity\HotSpots $hotspot)
    {
        $this->hotspots->removeElement($hotspot);
    }

    /**
     * Get hotspots
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHotspots()
    {
        return $this->hotspots;
    }

    /**
     * Add session
     *
     * @param \AppBundle\Entity\Session $session
     *
     * @return CaseStudy
     */
    public function addSession(\AppBundle\Entity\Session $session)
    {
        $this->sessions[] = $session;

        return $this;
    }

    /**
     * Remove session
     *
     * @param \AppBundle\Entity\Session $session
     */
    public function removeSession(\AppBundle\Entity\Session $session)
    {
        $this->sessions->removeElement($session);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSessions()
    {
        return $this->sessions;
    }
}
