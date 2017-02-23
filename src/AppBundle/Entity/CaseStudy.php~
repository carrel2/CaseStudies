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
	 * @ORM\OneToMany(targetEntity="Day", mappedBy="caseStudy", cascade={"all"}, orphanRemoval=true)
	 */
	private $days;

	/**
	 * @ORM\OneToMany(targetEntity="User", mappedBy="caseStudy", cascade={"all"})
	 */
	private $users;

    public function __construct()
    {
        $this->days = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function __toString()
    {
        return strval($this->id);
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
     * Add day
     *
     * @param \AppBundle\Entity\Day $day
     *
     * @return CaseStudy
     */
    public function addDay(\AppBundle\Entity\Day $day)
    {
	$day->setCaseStudy($this);
        $this->days[] = $day;

        return $this;
    }

    /**
     * Remove day
     *
     * @param \AppBundle\Entity\Day $day
     */
    public function removeDay(\AppBundle\Entity\Day $day)
    {
        $this->days->removeElement($day);
        $day->setCaseStudy(null);
    }

    /**
     * Get days
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return CaseStudy
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $user->setCaseStudy($this);
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
        $user->setCaseStudy(null);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
