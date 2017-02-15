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
 * @ORM\Table(name = "classes")
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
     * @ORM\ManyToOne(targetEntity = "Registration", inversedBy = "classes")
     * @ORM\JoinColumn(name = "registration_id", referencedColumnName = "id")
     */
    private $professor_registration;

    /**
     * @ORM\OneToOne(targetEntity = "StudentRegistration", mappedBy = "registeredClass")
     */
    private $student_registration;
}