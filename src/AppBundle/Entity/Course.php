<?php
/**
 * Created by PhpStorm.
 * User: Yuanhan
 * Date: 2/14/2017
 * Time: 5:59 PM
 */
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
     * @ORM\Column(name="id", type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name = "name", type = "string", length = 255)
     */
    private $name;

    /**
     *
     * @ORM\ManyToOne(targetEntity = "User", inversedBy = "courses")
     * @ORM\JoinColumn(name = "user_id", referencedColumnName = "id", onDelete = "set null")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity = "Registration", mappedBy = "course")
     */
    private $registrations;

    /**
     * @ORM\OneToMany(targetEntity = "CLSPClass", mappedBy = "course")
     */
    private $classes;


    public function __construct()
    {
        $this->registrations = new ArrayCollection();
        $this->classes = new ArrayCollection();
    }

    public function getCourseId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}