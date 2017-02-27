<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Course
 * @ORM\Entity
 * @ORM\Table(name ="course")
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


}
