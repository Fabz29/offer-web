<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfferRepository")
 */
class Offer
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="offer", cascade={"persist"})
     */
    private $users;

    /**
     * @var object
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Thematic", mappedBy="offer", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $thematics;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Media", mappedBy="offerLogo", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $logo;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Media", mappedBy="offerBackground", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $background;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Media", mappedBy="offerDownload", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $fileDownload;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\StatsOffer", inversedBy="offer", cascade={"persist", "remove"})
     */
    private $statsOffer;


    public function __construct()
    {
        $this->thematics = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Offer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Offer
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
     * @return Offer
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
     * @param \DateTime $updatedAt
     *
     * @return Offer
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $user
     */
    public function addUser($user)
    {
        $this->users[] = $user;
    }

    /**
     * @param mixed $user
     */
    public function removeUser($user)
    {
        $this->users->removeElement($user);
    }

    /**
     * @return mixed
     */
    public function getThematics()
    {
        return $this->thematics;
    }

    /**
     * @param mixed $thematic
     */
    public function addThematic($thematic)
    {
        $this->thematics[] = $thematic;
    }

    /**
     * @param mixed $thematic
     */
    public function removeThematic($thematic)
    {
        $this->thematics->removeElement($thematic);
    }

    /**
     * @return object
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param object $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return object
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @param object $background
     */
    public function setBackground($background)
    {
        $this->background = $background;
    }

    /**
     * @return object
     */
    public function getFileDownload()
    {
        return $this->fileDownload;
    }

    /**
     * @param object $fileDownload
     */
    public function setFileDownload($fileDownload)
    {
        $this->fileDownload = $fileDownload;
    }

    /**
     * @return object
     */
    public function getStatsOffer()
    {
        return $this->statsOffer;
    }

    /**
     * @param object $statsOffer
     */
    public function setStatsOffer($statsOffer)
    {
        $this->statsOffer = $statsOffer;
    }
}

