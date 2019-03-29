<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * StatsSubThematic
 *
 * @ORM\Table(name="stats_sub_thematic")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatsSubThematicRepository")
 */
class StatsSubThematic
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
     * @ORM\Column(name="sub_thematic_name", type="string", length=255)
     */
    private $subThematicName;

    /**
     * @var Integer
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time = 0;

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
     * @Gedmo\Slug(fields={"subThematicName"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var object
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\StatsUser", inversedBy="statsSubThematics", cascade={"persist"})
     */
    private $statsUser;

    /**
     * @var object
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Thematic", inversedBy="statsSubThematics", cascade={"persist", "remove"})
     */
    private $subThematic;

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
     * Set subThematicName.
     *
     * @param string $subThematicName
     *
     * @return StatsSubThematic
     */
    public function setSubThematicName($subThematicName)
    {
        $this->subThematicName = $subThematicName;

        return $this;
    }

    /**
     * Get subThematicName.
     *
     * @return string
     */
    public function getSubThematicName()
    {
        return $this->subThematicName;
    }

    /**
     * Set time.
     *
     * @param \DateTime $time
     *
     * @return StatsSubThematic
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time.
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
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
     * @return object
     */
    public function getStatsUser()
    {
        return $this->statsUser;
    }

    /**
     * @param object $statsUser
     */
    public function setStatsUser($statsUser)
    {
        $this->statsUser = $statsUser;
    }

    /**
     * @return object
     */
    public function getSubThematic(): object
    {
        return $this->subThematic;
    }

    /**
     * @param object $subThematic
     */
    public function setSubThematic(object $subThematic): void
    {
        $this->subThematic = $subThematic;
    }
}
