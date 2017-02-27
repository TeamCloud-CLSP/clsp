<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleDw (Module Discussion and Writing)
 *
 * @ORM\Table(name="module_dw")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleDwRepository")
 */
class ModuleDw
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
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $hasPassword;

    /**
     * One ModuleDw has One Song
     * @ORM\OneToOne(targetEntity="Song", inversedBy="moduleDw")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id")
     */
    private $song;

    /**
     * One ModuleDw has Many Question Headings.
     * @ORM\OneToMany(targetEntity="ModuleQuestionHeading", mappedBy="moduleDw")
     */
    private $headings;

    public function __construct() {
        $this->headings = new ArrayCollection();
    }
}

