<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Song
 *
 * @ORM\Table(name="song")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SongRepository")
 */
class Song
{
    /**
     * @var int $id Unique Song ID
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title Song Title
     *
     * @ORM\Column(type = "string")
     */
    private $title;

    /**
     * @var string $album Song Album
     *
     * @ORM\Column(type = "string")
     */
    private $album;

    /**
     * @var string $artist Song Artist
     *
     * @ORM\Column(type = "string")
     */
    private $artist;

    /**
     * @var string $description Song Description
     *
     * @ORM\Column(type = "string")
     */
    private $description;

    /**
     * @var string $lyrics Song Lyrics
     *
     * @ORM\Column(type = "string")
     */
    private $lyrics;

    /**
     * @var string $fileName Song File Name
     *
     * @ORM\Column(type = "string")
     */
    private $fileName;

    /**
     * @var string $fileType File Type of Song File
     *
     * @ORM\Column(type = "string")
     */
    private $fileType;

    /**
     * @var string $embed Embed Code for a Song
     *
     * @ORM\Column(type = "string")
     */
    private $embed;

    /**
     * Many Songs have One Unit.
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="songs")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     */
    private $unit;

    /**
     * One Song has One ModuleCn
     * @ORM\OneToOne(targetEntity="ModuleCn", mappedBy="song")
     */
    private $moduleCn;

    /**
     * One Song has One ModuleQu
     * @ORM\OneToOne(targetEntity="ModuleQu", mappedBy="song")
     */
    private $moduleQu;

    /**
     * One Song has One ModuleLt
     * @ORM\OneToOne(targetEntity="ModuleLt", mappedBy="song")
     */
    private $moduleLt;

    /**
     * One Song has One ModuleGe
     * @ORM\OneToOne(targetEntity="ModuleGe", mappedBy="song")
     */
    private $moduleGe;

    /**
     * One Song has One ModuleDw
     * @ORM\OneToOne(targetEntity="ModuleDw", mappedBy="song")
     */
    private $moduleDw;

    /**
     * One Song has One ModuleLs
     * @ORM\OneToOne(targetEntity="ModuleLs", mappedBy="song")
     */
    private $moduleLs;

}

