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
	* @ORM\Column(type="string", length=80)
	*/
	private $title;

	/**
	* @ORM\Column(type="text")
	*/
	private $description;

	/**
	* @ORM\Column(type="text")
	*/
	private $email;

	/**
	* @ORM\ManyToOne(targetEntity="Animal", inversedBy="cases")
	* @ORM\JoinColumn(name="animal_id", referencedColumnName="id", onDelete="SET NULL")
	*/
	private $animal;

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
		return $this->title;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function addDay(\AppBundle\Entity\Day $day)
	{
		if( !$this->days->contains($day) ) {
			$day->setCaseStudy($this);
			$this->days->add($day);
		}

		return $this;
	}

	public function removeDay(\AppBundle\Entity\Day $day)
	{
		$this->days->removeElement($day);
		$day->setCaseStudy(null);

		return $this;
	}

	public function getDays()
	{
		return $this->days;
	}

	public function addUser(\AppBundle\Entity\User $user)
	{
		if( !$this->users->contains($user) ) {
			$user->setCaseStudy($this);
			$this->users->add($user);
		}

		return $this;
	}

	public function removeUser(\AppBundle\Entity\User $user)
	{
		$this->users->removeElement($user);
		$user->setCaseStudy(null);

		return $this;
	}

	public function getUsers()
	{
		return $this->users;
	}

    public function setAnimal(\AppBundle\Entity\Animal $animal = null)
    {
        $this->animal = $animal;

        return $this;
    }

    public function getAnimal()
    {
        return $this->animal;
    }
}
