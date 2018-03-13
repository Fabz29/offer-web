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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
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
