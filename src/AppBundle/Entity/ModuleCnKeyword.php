<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModuleCnKeyword
 *
 * @ORM\Table(name="module_cn_keyword")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleCnKeywordRepository")
 */
class ModuleCnKeyword
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
    private $phrase;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $documentFile;

    /**
     * Many ModuleCnKeywords have One ModuleCn.
     * @ORM\ManyToOne(targetEntity="ModuleCn", inversedBy="keywords")
     * @ORM\JoinColumn(name="cn_id", referencedColumnName="id")
     */
    private $moduleCn;
}

