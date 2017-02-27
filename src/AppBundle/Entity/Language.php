<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LanguageRepository")
 */
class Language
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
     * @var string $languageCode ISO 639-1 Language Code
     *
     * @ORM\Column(type = "string", length = 2)
     */
    private $languageCode;

    /**
     * @var string $name string name of the language (ex. Japanese)
     *
     * @ORM\Column(type = "string", length = 2)
     */
    private $name;

    /**
     * One Language has Many Courses
     * @ORM\OneToMany(targetEntity="Course", mappedBy="language")
     */
    private $courses;

    public function __construct() {
        $this->courses = new ArrayCollection();
    }
}

