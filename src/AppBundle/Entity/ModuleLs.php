<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleLs (Module Listening Suggestions)
 *
 * @ORM\Table(name="module_ls")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleLsRepository")
 */
class ModuleLs
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
     * One ModuleLs has One Song
     * @ORM\OneToOne(targetEntity="Song", inversedBy="moduleLs")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id")
     */
    private $song;

    /**
     * One ModuleLs has Many Question Headings.
     * @ORM\OneToMany(targetEntity="ModuleQuestionHeading", mappedBy="moduleLs")
     */
    private $headings;

    public function __construct() {
        $this->headings = new ArrayCollection();
    }
}

