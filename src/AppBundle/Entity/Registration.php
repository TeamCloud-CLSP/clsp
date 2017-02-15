<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Registration
 *
 * @ORM\Table(name="professor_registrations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegistrationRepository")
 */
class Registration
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="prof_registrations")
     * @ORM\JoinColumn(name = "professor_id", referencedColumnName = "id", onDelete = "set null")
     */
    private $professor;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="owned_registrations")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="set null")
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="registrations")
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


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Registration
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     *
     * @return Registration
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return int
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
     * @return Registration
     */
    public function setDateDeleted($dateDeleted)
    {
        $this->dateDeleted = $dateDeleted;

        return $this;
    }

    /**
     * Get dateDeleted
     *
     * @return int
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
     * @return Registration
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return int
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
     * @return Registration
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return int
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
     * @return Registration
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
     * Constructor
     */
    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->student_registrations = new ArrayCollection();
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\Registration $user
     *
     * @return Registration
     */
    public function addUser(\AppBundle\Entity\Registration $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\Registration $user
     */
    public function removeUser(\AppBundle\Entity\Registration $user)
    {
        $this->users->removeElement($user);
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Registration
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set owner
     *
     * @param \AppBundle\Entity\User $owner
     *
     * @return Registration
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
}
