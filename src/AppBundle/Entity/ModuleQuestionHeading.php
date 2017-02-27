<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleQuestionHeading
 *
 * @ORM\Table(name="module_question_heading")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleQuestionHeadingRepository")
 */
class ModuleQuestionHeading
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
     * @ORM\Column(type="string")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $choices;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $answers;

    /**
     * One Question Heading has Many Questions.
     * @ORM\OneToMany(targetEntity="ModuleQuestionItem", mappedBy="heading")
     */
    private $questions;

    /**
     * Many Question Headings have One ModuleQu.
     * @ORM\ManyToOne(targetEntity="ModuleQu", inversedBy="headings")
     * @ORM\JoinColumn(name="qu_id", referencedColumnName="id")
     */
    private $moduleQu;

    /**
     * Many Question Headings have One ModuleLt.
     * @ORM\ManyToOne(targetEntity="ModuleLt", inversedBy="headings")
     * @ORM\JoinColumn(name="lt_id", referencedColumnName="id")
     */
    private $moduleLt;

    /**
     * Many Question Headings have One ModuleGe.
     * @ORM\ManyToOne(targetEntity="ModuleGe", inversedBy="headings")
     * @ORM\JoinColumn(name="ge_id", referencedColumnName="id")
     */
    private $moduleGe;

    /**
     * Many Question Headings have One ModuleDw.
     * @ORM\ManyToOne(targetEntity="ModuleDw", inversedBy="headings")
     * @ORM\JoinColumn(name="dw_id", referencedColumnName="id")
     */
    private $moduleDw;

    /**
     * Many Question Headings have One ModuleLs.
     * @ORM\ManyToOne(targetEntity="ModuleLs", inversedBy="headings")
     * @ORM\JoinColumn(name="ls_id", referencedColumnName="id")
     */
    private $moduleLs;

    public function __construct() {
        $this->questions = new ArrayCollection();
    }

}

