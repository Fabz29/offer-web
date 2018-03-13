<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Thematic
 *
 * @ORM\Table(name="thematic")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ThematicRepository")
 */
class Thematic
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="is_template", type="boolean")
     */
    private $isTemplate = false;

    /**
     * @var int
     *
     * @ORM\Column(name="suite_number", type="integer")
     */
    private $suiteNumber = 1;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var object
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Offer", inversedBy="thematics", cascade={"persist"})
     */
    private $offer;

    /**
     * @var object
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Slide", mappedBy="thematic", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $slides;

    /**
     * @var object
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Thematic", mappedBy="parentThematic", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $subThematics;

    /**
     * @var object
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thematic", inversedBy="subThematics", cascade={"persist"})
     */
    private $parentThematic;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Media", mappedBy="thematicThumbnail", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $thumbnail;

    public function __construct()
    {
        $this->slides = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subThematics = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Thematic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get isTemplate
     *
     * @return string
     */
    public function getIsTemplate()
    {
        return $this->isTemplate;
    }

    /**
     * Set isTemplate
     *
     * @param string $isTemplate
     *
     * @return Thematic
     */
    public function setIsTemplate($isTemplate)
    {
        $this->isTemplate = $isTemplate;

        return $this;
    }

    /**
     * Set suiteNumber
     *
     * @param int $suiteNumber
     *
     * @return Thematic
     */
    public function setSuiteNumber($suiteNumber)
    {
        $this->suiteNumber = $suiteNumber;

        return $this;
    }

    /**
     * Get suiteNumber
     *
     * @return int
     */
    public function getSuiteNumber()
    {
        return $this->suiteNumber;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Thematic
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Thematic
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param string $updatedAt
     *
     * @return Thematic
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return object
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @param object $offer
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
    }

    /**
     * @return object
     */
    public function getSlides()
    {
        return $this->slides;
    }

    /**
     * @param mixed $slide
     */
    public function addSlide($slide)
    {
        $this->slides[] = $slide;
    }

    /**
     * @param mixed $slide
     */
    public function removeSlide($slide)
    {
        $this->slides->removeElement($slide);
    }

    /**
     * @return object
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param object $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return object
     */
    public function getSubThematics()
    {
        return $this->subThematics;
    }

    /**
     * @param mixed $subThematic
     */
    public function addSubThematic($subThematic)
    {
        $this->subThematics[] = $subThematic;
    }

    /**
     * @param mixed $subThematic
     */
    public function removeSubThematic($subThematic)
    {
        $this->subThematics->removeElement($subThematic);
    }

    /**
     * @return object
     */
    public function getParentThematic()
    {
        return $this->parentThematic;
    }

    /**
     * @param object $parentThematic
     */
    public function setParentThematic($parentThematic)
    {
        $this->parentThematic = $parentThematic;
    }

    public function __clone() {
        $this->id = null;
        $this->parentThematic = null;
        $this->setIsTemplate(false);
    }
}

