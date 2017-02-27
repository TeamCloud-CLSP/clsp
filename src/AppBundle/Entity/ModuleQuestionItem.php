<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleQuestionItem
 *
 * @ORM\Table(name="module_question_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleQuestionItemRepository")
 */
class ModuleQuestionItem
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
     * @var string $content Body of the question
     *
     * @ORM\Column(type="string")
     */
    private $content;

    /**
     * @var string $type Question type (Text Only (TO), Multiple Choice (MC), etc)
     *
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @var integer $weight Question Weight (affects how the questions will be ordered in a list)
     *
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @var string $choices Question Choices (Comma separated list of possible question choices)
     *
     * @ORM\Column(type="string")
     */
    private $choices;

    /**
     * @var string $answers Question Answers (Comma sepearted list of possible question answers)
     *
     * @ORM\Column(type="string")
     */
    private $answers;

    /**
     * Many Questions have One Heading.
     * @ORM\ManyToOne(targetEntity="ModuleQuestionHeading", inversedBy="questions")
     * @ORM\JoinColumn(name="heading_id", referencedColumnName="id")
     */
    private $heading;


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
     * @return ModuleQuestionItem
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
     * @return ModuleQuestionItem
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
     * @return ModuleQuestionItem
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
     * @return ModuleQuestionItem
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
     * @return ModuleQuestionItem
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
     * Set heading
     *
     * @param \AppBundle\Entity\ModuleQuestionHeading $heading
     *
     * @return ModuleQuestionItem
     */
    public function setHeading(\AppBundle\Entity\ModuleQuestionHeading $heading = null)
    {
        $this->heading = $heading;

        return $this;
    }

    /**
     * Get heading
     *
     * @return \AppBundle\Entity\ModuleQuestionHeading
     */
    public function getHeading()
    {
        return $this->heading;
    }
}
