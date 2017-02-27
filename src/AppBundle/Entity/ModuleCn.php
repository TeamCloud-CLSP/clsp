<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleCn (Module Culture Notes)
 *
 * @ORM\Table(name="module_cn")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleCnRepository")
 */
class ModuleCn
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
     * One ModuleCn has One Song
     * @ORM\OneToOne(targetEntity="Song", inversedBy="moduleCn")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id")
     */
    private $song;

    /**
     * One ModuleCn has Many ModuleCnKeyword.
     * @ORM\OneToMany(targetEntity="ModuleCnKeyword", mappedBy="moduleCn")
     */
    private $keywords;

    public function __construct() {
        $this->keywords = new ArrayCollection();
    }


}

