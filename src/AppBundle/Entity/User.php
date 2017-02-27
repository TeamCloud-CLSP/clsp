<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="date_created", type="integer", length=64)
     */
    private $dateCreated;

    /**
     * @ORM\Column(name="date_deleted", type="integer", length=64, nullable=true)
     */
    private $dateDeleted;

    /**
     * @ORM\Column(name="date_start", type="integer", length=64)
     */
    private $dateStart;

    /**
     * @ORM\Column(name="date_end", type="integer", length=64)
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $timezone;

    /**
     * @ORM\Column(name="is_student", type="boolean")
     */
    private $isStudent;

    /**
     * @ORM\Column(name="is_professor", type="boolean")
     */
    private $isProfessor;

    /**
     * @ORM\Column(name="is_designer", type="boolean")
     */
    private $isDesigner;

    /**
     * @ORM\Column(name="forgot_password_key", type="string", nullable=true)
     */
    private $forgotPasswordKey;

    /**
     * @ORM\Column(name="forgot_password_expiry", type="integer", nullable=true)
     */
    private $forgotPasswordExpiry;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $signupCode;

    /**
     * @ORM\Column(name="is_administrator", type="boolean")
     */
    private $isAdministrator;

    /**
     * @ORM\OneToMany(targetEntity="ProfessorRegistration", mappedBy="owner")
     */
    private $owned_registrations;

    /**
     * @ORM\OneToMany(targetEntity="ProfessorRegistration", mappedBy="professor")
     */
    private $prof_registrations;

    /**
     * @ORM\OneToMany(targetEntity = "Course", mappedBy = "designer")
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity="StudentRegistration", mappedBy = "designer")
     */
    private $student_registrations;

    /**
     * @ORM\ManyToOne(targetEntity = "StudentRegistration", inversedBy = "students")
     * @ORM\JoinColumn(name = "student_registration_id", referencedColumnName = "id")
     */
    private $registered_class;

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
        $this->courses = new ArrayCollection();
        $this->student_registrations = new ArrayCollection();
        $this->owned_registrations = new ArrayCollection();
        $this->prof_registrations = new ArrayCollection();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        $roles = array();
        if($this->getIsStudent()) {
            array_push($roles, 'ROLE_STUDENT');
        }
        if($this->getIsProfessor()) {
            array_push($roles, 'ROLE_PROFESSOR');
        }
        if($this->getIsDesigner()) {
            array_push($roles, 'ROLE_DESIGNER');
        }
        if($this->getIsAdministrator()) {
            array_push($roles, 'ROLE_ADMIN');
        }
        return $roles;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
    
    public function getUserInfo()
    {
        $fields = array(
            "username",
            "email",
            "isActive",
            "dateCreated",
            "dateDeleted",
            "dateStart",
            "dateEnd",
            "timezone",
            "isStudent",
            "isProfessor",
            "isDesigner",
            "isAdministrator"
        );
        $userArray = array();
        foreach ($fields as $f) {
            $userArray[$f] = $this->{$f};
        }
        return $userArray;
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     *
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * Set timezone
     *
     * @param string $timezone
     *
     * @return User
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set isStudent
     *
     * @param boolean $isStudent
     *
     * @return User
     */
    public function setIsStudent($isStudent)
    {
        $this->isStudent = $isStudent;

        return $this;
    }

    /**
     * Get isStudent
     *
     * @return boolean
     */
    public function getIsStudent()
    {
        return $this->isStudent;
    }

    /**
     * Set isProfessor
     *
     * @param boolean $isProfessor
     *
     * @return User
     */
    public function setIsProfessor($isProfessor)
    {
        $this->isProfessor = $isProfessor;

        return $this;
    }

    /**
     * Get isProfessor
     *
     * @return boolean
     */
    public function getIsProfessor()
    {
        return $this->isProfessor;
    }

    /**
     * Set isDesigner
     *
     * @param boolean $isDesigner
     *
     * @return User
     */
    public function setIsDesigner($isDesigner)
    {
        $this->isDesigner = $isDesigner;

        return $this;
    }

    /**
     * Get isDesigner
     *
     * @return boolean
     */
    public function getIsDesigner()
    {
        return $this->isDesigner;
    }

    /**
     * Set forgotPasswordKey
     *
     * @param string $forgotPasswordKey
     *
     * @return User
     */
    public function setForgotPasswordKey($forgotPasswordKey)
    {
        $this->forgotPasswordKey = $forgotPasswordKey;

        return $this;
    }

    /**
     * Get forgotPasswordKey
     *
     * @return string
     */
    public function getForgotPasswordKey()
    {
        return $this->forgotPasswordKey;
    }

    /**
     * Set forgotPasswordExpiry
     *
     * @param integer $forgotPasswordExpiry
     *
     * @return User
     */
    public function setForgotPasswordExpiry($forgotPasswordExpiry)
    {
        $this->forgotPasswordExpiry = $forgotPasswordExpiry;

        return $this;
    }

    /**
     * Get forgotPasswordExpiry
     *
     * @return integer
     */
    public function getForgotPasswordExpiry()
    {
        return $this->forgotPasswordExpiry;
    }

    /**
     * Set isAdministrator
     *
     * @param boolean $isAdministrator
     *
     * @return User
     */
    public function setIsAdministrator($isAdministrator)
    {
        $this->isAdministrator = $isAdministrator;

        return $this;
    }

    /**
     * Get isAdministrator
     *
     * @return boolean
     */
    public function getIsAdministrator()
    {
        return $this->isAdministrator;
    }

    /**
     * Add ownedRegistration
     *
     * @param \AppBundle\Entity\ProfessorRegistration $ownedRegistration
     *
     * @return User
     */
    public function addOwnedRegistration(\AppBundle\Entity\ProfessorRegistration $ownedRegistration)
    {
        $this->owned_registrations[] = $ownedRegistration;

        return $this;
    }

    /**
     * Remove ownedRegistration
     *
     * @param \AppBundle\Entity\ProfessorRegistration $ownedRegistration
     */
    public function removeOwnedRegistration(\AppBundle\Entity\ProfessorRegistration $ownedRegistration)
    {
        $this->owned_registrations->removeElement($ownedRegistration);
    }

    /**
     * Get ownedRegistrations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOwnedRegistrations()
    {
        return $this->owned_registrations;
    }

    /**
     * Add profRegistration
     *
     * @param \AppBundle\Entity\ProfessorRegistration $profRegistration
     *
     * @return User
     */
    public function addProfRegistration(\AppBundle\Entity\ProfessorRegistration $profRegistration)
    {
        $this->prof_registrations[] = $profRegistration;

        return $this;
    }

    /**
     * Remove profRegistration
     *
     * @param \AppBundle\Entity\ProfessorRegistration $profRegistration
     */
    public function removeProfRegistration(\AppBundle\Entity\ProfessorRegistration $profRegistration)
    {
        $this->prof_registrations->removeElement($profRegistration);
    }

    /**
     * Get profRegistrations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfRegistrations()
    {
        return $this->prof_registrations;
    }

    /**
     * Add course
     *
     * @param \AppBundle\Entity\Course $course
     *
     * @return User
     */
    public function addCourse(\AppBundle\Entity\Course $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param \AppBundle\Entity\Course $course
     */
    public function removeCourse(\AppBundle\Entity\Course $course)
    {
        $this->courses->removeElement($course);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Add studentRegistration
     *
     * @param \AppBundle\Entity\StudentRegistration $studentRegistration
     *
     * @return User
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

    /**
     * Set registeredClass
     *
     * @param \AppBundle\Entity\StudentRegistration $registeredClass
     *
     * @return User
     */
    public function setRegisteredClass(\AppBundle\Entity\StudentRegistration $registeredClass = null)
    {
        $this->registered_class = $registeredClass;

        return $this;
    }

    /**
     * Get registeredClass
     *
     * @return \AppBundle\Entity\StudentRegistration
     */
    public function getRegisteredClass()
    {
        return $this->registered_class;
    }
}
