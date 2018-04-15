<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * StatsOffer
 *
 * @ORM\Table(name="stats_offer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatsOfferRepository")
 */
class StatsOffer
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
     * @ORM\Column(name="offer_name", type="string", length=255)
     */
    private $offerName;

    /**
     * @var Integer
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="number_download", type="integer")
     */
    private $numberDownload = 0;

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
     * @Gedmo\Slug(fields={"offerName"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var object
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\StatsUser", mappedBy="statsOffer", cascade={"persist", "remove"})
     */
    private $statsUsers;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Offer", mappedBy="statsOffer", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $offer;


    public function __construct()
    {
        $this->statsUsers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set offerName.
     *
     * @param string $offerName
     *
     * @return StatsOffer
     */
    public function setOfferName($offerName)
    {
        $this->offerName = $offerName;

        return $this;
    }

    /**
     * Get offerName.
     *
     * @return string
     */
    public function getOfferName()
    {
        return $this->offerName;
    }

    /**
     * Set time.
     *
     * @param \DateTime|null $time
     *
     * @return StatsOffer
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
     * Set numberDownload.
     *
     * @param int $numberDownload
     *
     * @return StatsOffer
     */
    public function setNumberDownload($numberDownload)
    {
        $this->numberDownload = $numberDownload;

        return $this;
    }

    /**
     * Get numberDownload.
     *
     * @return int
     */
    public function getNumberDownload()
    {
        return $this->numberDownload;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return StatsOffer
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
     * @return StatsOffer
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
     * @return StatsOffer
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatsUsers()
    {
        return $this->statsUsers;
    }

    /**
     * @param mixed $statsUser
     */
    public function addStatsUser($statsUser)
    {
        if (!$this->hasStatsUser($statsUser)) {
            $this->statsUsers[] = $statsUser;
        }
    }

    /**
     * @param mixed $statsUser
     */
    public function removeStatsUser($statsUser)
    {
        $this->statsUsers->removeElement($statsUser);
    }

    /**
     * @param mixed $statsUser
     *
     * @return bool
     */
    public function hasStatsUser($statsUser)
    {
        return $this->statsUsers->contains($statsUser);
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
}
