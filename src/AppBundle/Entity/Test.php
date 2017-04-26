<?php
// src/AppBundle/Entity/Test.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Diagnostic Test class
 *
 * Contains information about a specific diagnostic Test
 *
 * @ORM\Entity
 * @ORM\Table(name="Tests")
 */
class Test
{
	/**
	 * Auto-generated unique id
	 *
	 * @var integer
	 *
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * The name of the Test
	 *
	 * @var string
	 *
	 * @ORM\Column(type="string", length=40)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=40)
	 */
	private $group;

	/**
	 * The cost of the Test
	 *
	 * @var string
	 *
	 * @ORM\Column(type="string", length=10)
	 */
	private $cost;

	/**
	 * ArrayCollection of TestResults
	 *
	 * @var ArrayCollection
	 *
	 * @see ArrayCollection::class
	 * @see TestResults::class
	 *
	 * @ORM\OneToMany(targetEntity="TestResults", mappedBy="test")
	 */
	private $results;

	/**
	 * Constructor function
	 *
	 * Initializes $results as ArrayCollection
	 *
	 * @see ArrayCollection::class
	 */
	public function __construct(array $array = null)
	{
		$this->results = new ArrayCollection();
		if( $array )
		{
			$this->name = $array["name"];
			$this->cost = $array["cost"] === null ? 0 : $array["cost"];
		}
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
     * Set name
     *
     * @param string $name
     *
     * @return self
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
		 *
		 */
		public function setGroup($group)
		{
			$this->group = $group;

			return $this;
		}

		/**
		 *
		 */
		public function getGroup()
		{
			return $this->group;
		}

    /**
     * Set cost
     *
     * @param string $cost
     *
     * @return self
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Add result
     *
     * @param \AppBundle\Entity\TestResults $result
		 *
		 * @see TestResults::class
     *
     * @return self
     */
    public function addResult(\AppBundle\Entity\TestResults $result)
    {
        $this->results[] = $result;

        return $this;
    }

    /**
     * Remove result
     *
     * @param \AppBundle\Entity\TestResults $result
		 *
		 * @see TestResults::class
		 *
		 * @return self
     */
    public function removeResult(\AppBundle\Entity\TestResults $result)
    {
        $this->results->removeElement($result);

				return $this;
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResults()
    {
        return $this->results;
    }
}
