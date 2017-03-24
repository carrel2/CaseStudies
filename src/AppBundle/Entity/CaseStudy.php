<?php
// src/AppBundle/Entity/CaseStudy.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
* Case Study class
*
* Contains case study information
*
* @ORM\Entity
* @ORM\Table(name="Cases")
*/
class CaseStudy
{
	/**
	* Auto-generated unique id
	*
	* @var integer Unique id
	*
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	* The title of the CaseStudy
	*
	* @var string
	*
	* @ORM\Column(type="string", length=40)
	*/
	private $title;

	/**
	* A description of the CaseStudy
	*
	* Contains initial information for the CaseStudy
	*
	* @var string
	*
	* @ORM\Column(type="text")
	*/
	private $description;

	/**
	* The Animal associated with the CaseStudy
	*
	* @var Animal
	*
	* @see Animal::class
	*
	* @ORM\ManyToOne(targetEntity="Animal", inversedBy="cases")
	*/
	private $animal;

	/**
	* ArrayCollection of Day objects
	*
	* @var ArrayCollection
	*
	* @see ArrayCollection::class
	* @see Day::class
	*
	* @ORM\OneToMany(targetEntity="Day", mappedBy="caseStudy", cascade={"all"}, orphanRemoval=true)
	*/
	private $days;

	/**
	* ArrayCollection of User objects
	*
	* @var ArrayCollection
	*
	* @see ArrayCollection::class
	* @see User::class
	*
	* @ORM\OneToMany(targetEntity="User", mappedBy="caseStudy", cascade={"all"})
	*/
	private $users;

	/**
	* Constructor function
	*
	* Initializes $days, $users, $results as ArrayCollection
	*
	* @see ArrayCollection::class
	*/
	public function __construct()
	{
		$this->days = new ArrayCollection();
		$this->users = new ArrayCollection();
	}

	/**
	* Returns a string representation of the CaseStudy
	*
	* @return string
	*/
	public function __toString()
	{
		return $this->title;
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
	* @param string $title
	*
	* @return self
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
	* @return self
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
	* Appends $day to $days and associates $this as the CaseStudy for $day
	*
	* @param \AppBundle\Entity\Day $day
	*
	* @return self
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
	* Removes $day from $days and removes association between $this and $day
	*
	* @param \AppBundle\Entity\Day $day
	*
	* @return self
	*/
	public function removeDay(\AppBundle\Entity\Day $day)
	{
		$this->days->removeElement($day);
		$day->setCaseStudy(null);

		return $this;
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
	* Appends $user to $users and associates $this as the CaseStudy for $user
	*
	* @param \AppBundle\Entity\User $user
	*
	* @return self
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
	* Removes $user from $users and removes association between $this and $user
	*
	* @param \AppBundle\Entity\User $user
	*
	* @return self
	*/
	public function removeUser(\AppBundle\Entity\User $user)
	{
		$this->users->removeElement($user);
		$user->setCaseStudy(null);

		return $this;
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

    /**
     * Set animal
     *
     * @param \AppBundle\Entity\Animal $animal
     *
     * @return CaseStudy
     */
    public function setAnimal(\AppBundle\Entity\Animal $animal = null)
    {
        $this->animal = $animal;

        return $this;
    }

    /**
     * Get animal
     *
     * @return \AppBundle\Entity\Animal
     */
    public function getAnimal()
    {
        return $this->animal;
    }
}
