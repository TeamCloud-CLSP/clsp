<?php
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
     * @var integer $id Unique course ID
     *
     * @ORM\Column(name="id", type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name Name of the course
     *
     * @ORM\Column(name = "name", type = "string", length = 255)
     */
    private $name;

    /**
     * @var string $description Course Description
     *
     * @ORM\Column(type = "string")
     */
    private $description;

    /**
     * @var $designer User that owns this course
     *
     * @ORM\ManyToOne(targetEntity = "User", inversedBy = "courses")
     * @ORM\JoinColumn(name = "user_id", referencedColumnName = "id", onDelete = "set null")
     */
    private $designer;

    /**
     * @var $professorRegistrations ProfessorRegistration that give access to this course
     *
     * @ORM\OneToMany(targetEntity = "ProfessorRegistration", mappedBy = "course")
     */
    private $professorRegistrations;

    /**
     * @var $classes CLSPClass's that use this course
     *
     * @ORM\OneToMany(targetEntity = "CLSPClass", mappedBy = "course")
     */
    private $classes;

    /**
     * Many Courses have One Language
     * @ORM\ManyToOne(targetEntity="Language", inversedBy="courses")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     */
    private $language;

    /**
     * One Course has Many Units.
     * @ORM\OneToMany(targetEntity="Unit", mappedBy="course")
     */
    private $units;


    public function __construct()
    {
        $this->professorRegistrations = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->units = new ArrayCollection();
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
     * Set description
     *
     * @param string $description
     *
     * @return Course
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

    /**
     * Set language
     *
     * @param \AppBundle\Entity\Language $language
     *
     * @return Course
     */
    public function setLanguage(\AppBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \AppBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Add unit
     *
     * @param \AppBundle\Entity\Unit $unit
     *
     * @return Course
     */
    public function addUnit(\AppBundle\Entity\Unit $unit)
    {
        $this->units[] = $unit;

        return $this;
    }

    /**
     * Remove unit
     *
     * @param \AppBundle\Entity\Unit $unit
     */
    public function removeUnit(\AppBundle\Entity\Unit $unit)
    {
        $this->units->removeElement($unit);
    }

    /**
     * Get units
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnits()
    {
        return $this->units;
    }
}
