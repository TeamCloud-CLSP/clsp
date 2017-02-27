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


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return ModuleQuestionHeading
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return ModuleQuestionHeading
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return ModuleQuestionHeading
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set choices
     *
     * @param string $choices
     *
     * @return ModuleQuestionHeading
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;

        return $this;
    }

    /**
     * Get choices
     *
     * @return string
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * Set answers
     *
     * @param string $answers
     *
     * @return ModuleQuestionHeading
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * Get answers
     *
     * @return string
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\ModuleQuestionItem $question
     *
     * @return ModuleQuestionHeading
     */
    public function addQuestion(\AppBundle\Entity\ModuleQuestionItem $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \AppBundle\Entity\ModuleQuestionItem $question
     */
    public function removeQuestion(\AppBundle\Entity\ModuleQuestionItem $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set moduleQu
     *
     * @param \AppBundle\Entity\ModuleQu $moduleQu
     *
     * @return ModuleQuestionHeading
     */
    public function setModuleQu(\AppBundle\Entity\ModuleQu $moduleQu = null)
    {
        $this->moduleQu = $moduleQu;

        return $this;
    }

    /**
     * Get moduleQu
     *
     * @return \AppBundle\Entity\ModuleQu
     */
    public function getModuleQu()
    {
        return $this->moduleQu;
    }

    /**
     * Set moduleLt
     *
     * @param \AppBundle\Entity\ModuleLt $moduleLt
     *
     * @return ModuleQuestionHeading
     */
    public function setModuleLt(\AppBundle\Entity\ModuleLt $moduleLt = null)
    {
        $this->moduleLt = $moduleLt;

        return $this;
    }

    /**
     * Get moduleLt
     *
     * @return \AppBundle\Entity\ModuleLt
     */
    public function getModuleLt()
    {
        return $this->moduleLt;
    }

    /**
     * Set moduleGe
     *
     * @param \AppBundle\Entity\ModuleGe $moduleGe
     *
     * @return ModuleQuestionHeading
     */
    public function setModuleGe(\AppBundle\Entity\ModuleGe $moduleGe = null)
    {
        $this->moduleGe = $moduleGe;

        return $this;
    }

    /**
     * Get moduleGe
     *
     * @return \AppBundle\Entity\ModuleGe
     */
    public function getModuleGe()
    {
        return $this->moduleGe;
    }

    /**
     * Set moduleDw
     *
     * @param \AppBundle\Entity\ModuleDw $moduleDw
     *
     * @return ModuleQuestionHeading
     */
    public function setModuleDw(\AppBundle\Entity\ModuleDw $moduleDw = null)
    {
        $this->moduleDw = $moduleDw;

        return $this;
    }

    /**
     * Get moduleDw
     *
     * @return \AppBundle\Entity\ModuleDw
     */
    public function getModuleDw()
    {
        return $this->moduleDw;
    }

    /**
     * Set moduleLs
     *
     * @param \AppBundle\Entity\ModuleLs $moduleLs
     *
     * @return ModuleQuestionHeading
     */
    public function setModuleLs(\AppBundle\Entity\ModuleLs $moduleLs = null)
    {
        $this->moduleLs = $moduleLs;

        return $this;
    }

    /**
     * Get moduleLs
     *
     * @return \AppBundle\Entity\ModuleLs
     */
    public function getModuleLs()
    {
        return $this->moduleLs;
    }
}
