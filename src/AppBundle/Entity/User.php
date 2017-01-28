<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
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
     * @ORM\ManyToOne(targetEntity="Registration", inversedBy="users")
     * @ORM\JoinColumn(name="registration_id", referencedColumnName="id", onDelete="set null")
     */
    private $registration;

    /**
     * @ORM\OneToMany(targetEntity="Registration", mappedBy="owner")
     */
    private $owned_registrations;

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
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
     * Set registration
     *
     * @param \AppBundle\Entity\Registration $registration
     *
     * @return User
     */
    public function setRegistration(\AppBundle\Entity\Registration $registration = null)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration
     *
     * @return \AppBundle\Entity\Registration
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Add registration
     *
     * @param \AppBundle\Entity\Registration $registration
     *
     * @return User
     */
    public function addRegistration(\AppBundle\Entity\Registration $registration)
    {
        $this->registrations[] = $registration;

        return $this;
    }

    /**
     * Remove registration
     *
     * @param \AppBundle\Entity\Registration $registration
     */
    public function removeRegistration(\AppBundle\Entity\Registration $registration)
    {
        $this->registrations->removeElement($registration);
    }

    /**
     * Get registrations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * Add ownedRegistration
     *
     * @param \AppBundle\Entity\Registration $ownedRegistration
     *
     * @return User
     */
    public function addOwnedRegistration(\AppBundle\Entity\Registration $ownedRegistration)
    {
        $this->owned_registrations[] = $ownedRegistration;

        return $this;
    }

    /**
     * Remove ownedRegistration
     *
     * @param \AppBundle\Entity\Registration $ownedRegistration
     */
    public function removeOwnedRegistration(\AppBundle\Entity\Registration $ownedRegistration)
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
     * Set plainPassword
     *
     * @param string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set signupCode
     *
     * @param string $signupCode
     *
     * @return User
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
     * Set forgotPasswordKey
     *
     * @param integer $forgotPasswordKey
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
     * @return integer
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
}
