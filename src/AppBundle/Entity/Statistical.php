<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Statistical
 *
 * @ORM\Table(name="statistical")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatisticalRepository")
 */
class Statistical
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
     * @var string|null
     *
     * @ORM\Column(name="userName", type="string", length=255, nullable=true)
     */
    private $userName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="offerName", type="string", length=255, nullable=true)
     */
    private $offerName;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ConnectionTime", type="time", nullable=true)
     */
    private $connectionTime;

    /**
     * @var bool
     *
     * @ORM\Column(name="isOfferDownload", type="boolean")
     */
    private $isOfferDownload = false;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"userName", "offerName"})
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
     * @var User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", mappedBy="statistical", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $user;

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
     * @return null|string
     */
    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @param null|string $userName
     */
    public function setUserName(?string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return null|string
     */
    public function getOfferName(): ?string
    {
        return $this->offerName;
    }

    /**
     * @param null|string $offerName
     */
    public function setOfferName(?string $offerName): void
    {
        $this->offerName = $offerName;
    }

    /**
     * Set connectionTime.
     *
     * @param \DateTime|null $connectionTime
     *
     * @return Statistical
     */
    public function setConnectionTime($connectionTime = null)
    {
        $this->connectionTime = $connectionTime;

        return $this;
    }

    /**
     * Get connectionTime.
     *
     * @return \DateTime|null
     */
    public function getConnectionTime()
    {
        return $this->connectionTime;
    }

    /**
     * Set isOfferDownload.
     *
     * @param bool $isOfferDownload
     *
     * @return Statistical
     */
    public function setIsOfferDownload($isOfferDownload)
    {
        $this->isOfferDownload = $isOfferDownload;

        return $this;
    }

    /**
     * Get isOfferDownload.
     *
     * @return bool
     */
    public function getIsOfferDownload()
    {
        return $this->isOfferDownload;
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
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Statistical
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
     * @return Statistical
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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
