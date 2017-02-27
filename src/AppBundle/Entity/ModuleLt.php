<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleLt (Module Listening Tasks)
 *
 * @ORM\Table(name="module_lt")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleLtRepository")
 */
class ModuleLt
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
     * One ModuleLt has One Song
     * @ORM\OneToOne(targetEntity="Song", inversedBy="moduleLt")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id")
     */
    private $song;

    /**
     * One ModuleLt has Many Question Headings.
     * @ORM\OneToMany(targetEntity="ModuleQuestionHeading", mappedBy="moduleLt")
     */
    private $headings;

    public function __construct() {
        $this->headings = new ArrayCollection();
    }
}

