<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Unit
 *
 * @ORM\Table(name="unit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UnitRepository")
 */
class Unit
{
    /**
     * @var int $id Unique Unit ID
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name Name of the Unit
     *
     * @ORM\Column(type = "string", length = 255)
     */
    private $name;

    /**
     * @var string $description Description for the Unit
     *
     * @ORM\Column(type = "string")
     */
    private $description;

    /**
     * Many Units have One Course.
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="units")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;

    /**
     * One Unit has Many Songs
     * @ORM\OneToMany(targetEntity="Song", mappedBy="unit")
     */
    private $songs;

    public function __construct() {
        $this->songs = new ArrayCollection();
    }


}

