<?php
/**
 * Created by PhpStorm.
 * User: Yuanhan
 * Date: 2/14/2017
 * Time: 6:36 PM
 */
namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class StudentRegistration
 * @ORM\Entity
 * @ORM\table(name="student_registration")
 */
class StudentRegistration
{
    /**
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
     * @var int
     *
     * @ORM\Column(name="date_created", type="integer")
     */
    private $dateCreated;

    /**
     * @var int
     *
     * @ORM\Column(name="date_deleted", type="integer", nullable=true)
     */
    private $dateDeleted;

    /**
     * @var int
     *
     * @ORM\Column(name="date_start", type="integer")
     */
    private $dateStart;

    /**
     * @var int
     *
     * @ORM\Column(name="date_end", type="integer")
     */
    private $dateEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="signup_code", type="string", length=255)
     */
    private $signupCode;

    /**
     * @ORM\ManyToOne(targetEntity = "User", inversedBy = "student_registrations")
     * @ORM\JoinColumn(name = "designer_id", referencedColumnName = "id")
     */
    private $designer;

    /**
     * @ORM\OneToMany(targetEntity = "User", mappedBy = "registered_class")
     *
     */
    private $students;


    /**
     * @ORM\OneToOne(targetEntity = "CLSPClass", inversedBy = "student_registration")
     * @ORM\JoinColumn(name = "class_id", referencedColumnName = "id")
     */
    private $registeredClass;

    /**
     * @ORM\ManyToOne(targetEntity = "ProfessorRegistration", inversedBy = "student_registrations")
     * @ORM\JoinColumn(name = "prof_registration_id", referencedColumnName = "id")
     */
    private $professor_registration;

    public function  __construct()
    {
        $this->students = new ArrayCollection();
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
     * @return StudentRegistration
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
     * Set dateCreated
     *
     * @param integer $dateCreated
     *
     * @return StudentRegistration
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return integer
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateDeleted
     *
     * @param integer $dateDeleted
     *
     * @return StudentRegistration
     */
    public function setDateDeleted($dateDeleted)
    {
        $this->dateDeleted = $dateDeleted;

        return $this;
    }

    /**
     * Get dateDeleted
     *
     * @return integer
     */
    public function getDateDeleted()
    {
        return $this->dateDeleted;
    }

    /**
     * Set dateStart
     *
     * @param integer $dateStart
     *
     * @return StudentRegistration
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return integer
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param integer $dateEnd
     *
     * @return StudentRegistration
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return integer
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set signupCode
     *
     * @param string $signupCode
     *
     * @return StudentRegistration
     */
    public function setSignupCode($signupCode)
    {
        $this->signupCode = $signupCode;

        return $this;
    }

    /**
     * Get signupCode
     *
     * @return string
     */
    public function getSignupCode()
    {
        return $this->signupCode;
    }

    /**
     * Set designer
     *
     * @param \AppBundle\Entity\User $designer
     *
     * @return StudentRegistration
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
     * Add student
     *
     * @param \AppBundle\Entity\User $student
     *
     * @return StudentRegistration
     */
    public function addStudent(\AppBundle\Entity\User $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \AppBundle\Entity\User $student
     */
    public function removeStudent(\AppBundle\Entity\User $student)
    {
        $this->students->removeElement($student);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Set registeredClass
     *
     * @param \AppBundle\Entity\CLSPClass $registeredClass
     *
     * @return StudentRegistration
     */
    public function setRegisteredClass(\AppBundle\Entity\CLSPClass $registeredClass = null)
    {
        $this->registeredClass = $registeredClass;

        return $this;
    }

    /**
     * Get registeredClass
     *
     * @return \AppBundle\Entity\CLSPClass
     */
    public function getRegisteredClass()
    {
        return $this->registeredClass;
    }

    /**
     * Set professorRegistration
     *
     * @param \AppBundle\Entity\ProfessorRegistration $professorRegistration
     *
     * @return StudentRegistration
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
}
