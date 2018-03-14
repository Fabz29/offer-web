<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="companyName", type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accessStartAt", type="datetime")
     */
    private $accessStartAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accessEndAt", type="datetime")
     */
    private $accessEndAt;

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
     * @var Offer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Offer", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $offer;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Statistical", inversedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $statistical;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Thematic", inversedBy="statUserReaders", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $statThematicViews;

    public function __construct()
    {
        parent::__construct();
        $accessStartAt = new \DateTime();
        $this->accessStartAt = new \DateTime();
        $accessEndAt = $accessStartAt->add(new \DateInterval("P1M"));
        $this->accessEndAt = $accessEndAt;
        $this->plainPassword = substr(hash('sha512',rand()),0,12);
        $this->statThematicViews = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $companyName;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set accessStartAt
     *
     * @param \DateTime $accessStartAt
     *
     * @return User
     */
    public function setAccessStartAt($accessStartAt)
    {
        $this->accessStartAt = $accessStartAt;

        return $this;
    }

    /**
     * Get accessStartAt
     *
     * @return \DateTime
     */
    public function getAccessStartAt()
    {
        return $this->accessStartAt;
    }

    /**
     * Set accessEndAt
     *
     * @param \DateTime $accessEndAt
     *
     * @return User
     */
    public function setAccessEndAt($accessEndAt)
    {
        $this->accessEndAt = $accessEndAt;

        return $this;
    }

    /**
     * Get accessEndAt
     *
     * @return \DateTime
     */
    public function getAccessEndAt()
    {
        return $this->accessEndAt;
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
     * @return User
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
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        parent::setEmail($email);
        $this->setUsername($email);
        return $this;
    }

    /**
     * @return User
     */
    public function getStatistical()
    {
        return $this->statistical;
    }

    /**
     * @param User $statistical
     */
    public function setStatistical($statistical)
    {
        $this->statistical = $statistical;
    }

    /**
     * @return ArrayCollection
     */
    public function getStatThematicViews()
    {
        return $this->statThematicViews;
    }

    /**
     * @param mixed $statThematicView
     */
    public function addStatThematicView($statThematicView)
    {
        $this->statThematicViews[] = $statThematicView;
    }

    /**
     * @param mixed $statThematicView
     */
    public function removeStatThematicView($statThematicView)
    {
        $this->statThematicViews->removeElement($statThematicView);
    }

}

