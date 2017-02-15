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
 * @ORM\table(name="student_registrations")
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
     * @ORM\OneToOne(targetEntity = "CLSPClass", mappedBy = "student_registration")
     * @ORM\JoinColumn(name = "class_id", referencedColumnName = "id")
     */
    private $registeredClass;

    /**
     * @ORM\ManyToOne(targetEntity = "Registration", inversedBy = "student_registrations")
     * @ORM\JoinColumn(name = "prof_registration_id", referencedColumnName = "id")
     */
    private $professor_registration;

    public function  __construct()
    {
        $this->students = new ArrayCollection();
    }
}