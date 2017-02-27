<?php
/**
 * Created by PhpStorm.
 * User: Yuanhan
 * Date: 2/14/2017
 * Time: 6:55 PM
 */
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CLSPClass
 * @ORM\Entity
 * @ORM\Table(name = "class")
 */
class CLSPClass
{
    /**
     * @var int
     * @ORM\Column(name = "id", type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name = "name", type = "string", length = 255)
     */
    private $name;


    /**
     * @ORM\ManyToOne(targetEntity = "Course", inversedBy = "classes")
     * @ORM\JoinColumn(name = "course_id", referencedColumnName = "id")
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity = "ProfessorRegistration", inversedBy = "classes")
     * @ORM\JoinColumn(name = "registration_id", referencedColumnName = "id")
     */
    private $professor_registration;

    /**
     * @ORM\OneToOne(targetEntity = "StudentRegistration", mappedBy = "registeredClass")
     */
    private $student_registration;

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
     * @return CLSPClass
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
     * Set course
     *
     * @param \AppBundle\Entity\Course $course
     *
     * @return CLSPClass
     */
    public function setCourse(\AppBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \AppBundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set professorRegistration
     *
     * @param \AppBundle\Entity\ProfessorRegistration $professorRegistration
     *
     * @return CLSPClass
     */
    public function setProfessorRegistration(\AppBundle\Entity\ProfessorRegistration $professorRegistration = null)
    {
        $this->professor_registration = $professorRegistration;

        return $this;
    }

    /**
     * Get professorRegistration
     *
     * @return \AppBundle\Entity\ProfessorRegistration
     */
    public function getProfessorRegistration()
    {
        return $this->professor_registration;
    }

    /**
     * Set studentRegistration
     *
     * @param \AppBundle\Entity\StudentRegistration $studentRegistration
     *
     * @return CLSPClass
     */
    public function setStudentRegistration(\AppBundle\Entity\StudentRegistration $studentRegistration = null)
    {
        $this->student_registration = $studentRegistration;

        return $this;
    }

    /**
     * Get studentRegistration
     *
     * @return \AppBundle\Entity\StudentRegistration
     */
    public function getStudentRegistration()
    {
        return $this->student_registration;
    }
}
