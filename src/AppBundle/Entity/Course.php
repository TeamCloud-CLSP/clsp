<?php
/**
 * Created by PhpStorm.
 * User: Yuanhan
 * Date: 2/14/2017
 * Time: 5:59 PM
 */
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Course
 * @ORM\Entity
 * @ORM\Table(name ="courses")
 */
class Course
{
    /**
     * @ORM\Column(name="id", type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name = "name", type = "string", length = 255)
     */
    private $name;

    /**
     *
     * @ORM\ManyToOne(targetEntity = "User", inversedBy = "courses")
     * @ORM\JoinColumn(name = "user_id", referencedColumnName = "id", onDelete = "set null")
     */
    private $designer;

    /**
     * @ORM\OneToMany(targetEntity = "ProfessorRegistration", mappedBy = "course")
     */
    private $professorRegistrations;

    /**
     * @ORM\OneToMany(targetEntity = "CLSPClass", mappedBy = "course")
     */
    private $classes;


    public function __construct()
    {
        $this->professorRegistrations = new ArrayCollection();
        $this->classes = new ArrayCollection();
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
     * @return Course
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
     * Set designer
     *
     * @param \AppBundle\Entity\User $designer
     *
     * @return Course
     */
    public function setDesigner(\AppBundle\Entity\User $designer = null)
    {
        $this->designer = $designer;

        return $this;
    }

    /**
     * Get designer
     *
     * @return \AppBundle\Entity\User
     */
    public function getDesigner()
    {
        return $this->designer;
    }

    /**
     * Add professorRegistration
     *
     * @param \AppBundle\Entity\ProfessorRegistration $professorRegistration
     *
     * @return Course
     */
    public function addProfessorRegistration(\AppBundle\Entity\ProfessorRegistration $professorRegistration)
    {
        $this->professorRegistrations[] = $professorRegistration;

        return $this;
    }

    /**
     * Remove professorRegistration
     *
     * @param \AppBundle\Entity\ProfessorRegistration $professorRegistration
     */
    public function removeProfessorRegistration(\AppBundle\Entity\ProfessorRegistration $professorRegistration)
    {
        $this->professorRegistrations->removeElement($professorRegistration);
    }

    /**
     * Get professorRegistrations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfessorRegistrations()
    {
        return $this->professorRegistrations;
    }

    /**
     * Add class
     *
     * @param \AppBundle\Entity\CLSPClass $class
     *
     * @return Course
     */
    public function addClass(\AppBundle\Entity\CLSPClass $class)
    {
        $this->classes[] = $class;

        return $this;
    }

    /**
     * Remove class
     *
     * @param \AppBundle\Entity\CLSPClass $class
     */
    public function removeClass(\AppBundle\Entity\CLSPClass $class)
    {
        $this->classes->removeElement($class);
    }

    /**
     * Get classes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClasses()
    {
        return $this->classes;
    }
}
