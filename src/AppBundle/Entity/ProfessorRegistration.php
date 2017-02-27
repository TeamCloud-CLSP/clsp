<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Registration
 *
 * @ORM\Table(name="professor_registration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegistrationRepository")
 */
class ProfessorRegistration
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="owned_registrations")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="set null")
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="prof_registrations")
     * @ORM\JoinColumn(name = "professor_id", referencedColumnName = "id", onDelete = "set null")
     */
    private $professor;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="professorRegistrations")
     * @ORM\JoinColumn(name = "course_id", referencedColumnName = "id", onDelete="set null")
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity = "CLSPClass", mappedBy = "professor_registration")
     */
    private $classes;

    /**
     * @ORM\OneToMany(targetEntity = "StudentRegistration", mappedBy = "professor_registration")
     */
    private $student_registrations;

    
    public function getRegistrationInfo()
    {
        $userArray['dateCreated'] = $this->dateCreated;
        $userArray['dateDeleted'] = $this->dateDeleted;
        $userArray['dateStart'] = $this->dateStart;
        $userArray['dateEnd'] = $this->dateEnd;
        $userArray['signupCode'] = $this->signupCode;
        $userArray['professor'] = $this->professor->username;
        $userArray['professor_id'] = $this->professor->id;
        $userArray['course'] = $this->course->name;
        $userArray['course_id'] = $this->course->id;
        return $userArray;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->student_registrations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateCreated
     *
     * @param integer $dateCreated
     *
     * @return ProfessorRegistration
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
     * @return ProfessorRegistration
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
     * @return ProfessorRegistration
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
     * @return ProfessorRegistration
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
     * @return ProfessorRegistration
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
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     *
     * @return ProfessorRegistration
     */
    public function setOwner(\AppBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \AppBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set professor
     *
     * @param \AppBundle\Entity\User $professor
     *
     * @return ProfessorRegistration
     */
    public function setProfessor(\AppBundle\Entity\User $professor = null)
    {
        $this->professor = $professor;

        return $this;
    }

    /**
     * Get professor
     *
     * @return \AppBundle\Entity\User
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * Set course
     *
     * @param \AppBundle\Entity\Course $course
     *
     * @return ProfessorRegistration
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
     * Add class
     *
     * @param \AppBundle\Entity\CLSPClass $class
     *
     * @return ProfessorRegistration
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
     * Add studentRegistration
     *
     * @param \AppBundle\Entity\StudentRegistration $studentRegistration
     *
     * @return ProfessorRegistration
     */
    public function addStudentRegistration(\AppBundle\Entity\StudentRegistration $studentRegistration)
    {
        $this->student_registrations[] = $studentRegistration;

        return $this;
    }

    /**
     * Remove studentRegistration
     *
     * @param \AppBundle\Entity\StudentRegistration $studentRegistration
     */
    public function removeStudentRegistration(\AppBundle\Entity\StudentRegistration $studentRegistration)
    {
        $this->student_registrations->removeElement($studentRegistration);
    }

    /**
     * Get studentRegistrations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudentRegistrations()
    {
        return $this->student_registrations;
    }
}
