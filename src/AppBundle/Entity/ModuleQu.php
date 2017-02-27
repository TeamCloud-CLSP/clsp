<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleQu (Module Questions for Understanding)
 *
 * @ORM\Table(name="module_qu")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleQuRepository")
 */
class ModuleQu
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
     * One ModuleQu has One Song
     * @ORM\OneToOne(targetEntity="Song", inversedBy="moduleQu")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id")
     */
    private $song;

    /**
     * One ModuleQu has Many Question Headings.
     * @ORM\OneToMany(targetEntity="ModuleQuestionHeading", mappedBy="moduleQu")
     */
    private $headings;

    public function __construct() {
        $this->headings = new ArrayCollection();
    }
}

