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

}

