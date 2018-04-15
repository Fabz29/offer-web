<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * StatsUser
 *
 * @ORM\Table(name="stats_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatsUserRepository")
 */
class StatsUser
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
     * @ORM\Column(name="userName", type="string", length=255)
     */
    private $userName;

    /**
     * @var Integer
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_download", type="boolean")
     */
    private $isDownload;

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
     * @var string
     *
     * @Gedmo\Slug(fields={"userName"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var object
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\StatsSubThematic", mappedBy="statsUser", cascade={"persist", "remove"})
     */
    private $statsSubThematics;

    /**
     * @var object
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\StatsOffer", inversedBy="statsUsers", cascade={"persist"})
     */
    private $statsOffer;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="statsUser", cascade={"persist", "remove"})
     */
    private $user;


    public function __construct()
    {
        $this->statsSubThematics = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userName.
     *
     * @param string $userName
     *
     * @return StatsUser
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName.
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set time.
     *
     * @param \DateTime|null $time
     *
     * @return StatsUser
     */
    public function setTime($time = null)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time.
     *
     * @return \DateTime|null
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set isDownload.
     *
     * @param bool $isDownload
     *
     * @return StatsUser
     */
    public function setIsDownload($isDownload)
    {
        $this->isDownload = $isDownload;

        return $this;
    }

    /**
     * Get isDownload.
     *
     * @return bool
     */
    public function getIsDownload()
    {
        return $this->isDownload;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return StatsUser
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
     * @return StatsUser
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
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return StatsUser
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatsSubThematics()
    {
        return $this->statsSubThematics;
    }

    /**
     * @param mixed $statsSubThematic
     */
    public function addStatsSubThematic($statsSubThematic)
    {
        $this->statsSubThematics[] = $statsSubThematic;
    }

    /**
     * @param mixed $statsSubThematic
     */
    public function removeStatsSubThematic($statsSubThematic)
    {
        $this->statsSubThematics->removeElement($statsSubThematic);
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

    /**
     * @return object
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param object $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

}
