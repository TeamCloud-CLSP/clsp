<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleGe (Module Grammar Exercise)
 *
 * @ORM\Table(name="module_ge")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleGeRepository")
 */
class ModuleGe
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
     * One ModuleGe has One Song
     * @ORM\OneToOne(targetEntity="Song", inversedBy="moduleGe")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id")
     */
    private $song;

    /**
     * One ModuleGe has Many Question Headings.
     * @ORM\OneToMany(targetEntity="ModuleQuestionHeading", mappedBy="moduleGe")
     */
    private $headings;

    public function __construct() {
        $this->headings = new ArrayCollection();
    }
}

