<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media
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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", nullable=true)
     */
    private $alt;

    /**
     * @var string
     *
     * @ORM\Column(name="is_enabled", type="boolean")
     */
    private $isEnabled = true;

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
     * @var file
     * @Assert\File(maxSize="5M", maxSizeMessage = "La taille du fichier ne doit pas dépasser 5 Mo")
     */
    private $file;

    private $tempFilename;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Slide", inversedBy="media", cascade={"persist"})
     * @Assert\Valid()
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $slide;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Offer", inversedBy="logo", cascade={"persist"})
     * @Assert\Valid()
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $offerLogo;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Offer", inversedBy="background", cascade={"persist"})
     * @Assert\Valid()
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $offerBackground;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Thematic", inversedBy="thumbnail", cascade={"persist"})
     * @Assert\Valid()
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $thematicThumbnail;

    /**
     * @var object
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Offer", inversedBy="fileDownload", cascade={"persist"})
     * @Assert\Valid()
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=true)
     */
    private $offerDownload;

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
     * Set path
     *
     * @param string $path
     *
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }


    /**
     * @return string
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * @param string $isEnabled
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Media
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
     * @return Media
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
     * @return file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        if (null !== $this->path) {
            $this->tempFilename = $this->path;
            $this->path = null;
            $this->alt = null;
        }
    }

    /**
     * @return object
     */
    public function getSlide()
    {
        return $this->slide;
    }

    /**
     * @param object $slide
     */
    public function setSlide($slide)
    {
        $this->slide = $slide;
    }

    /**
     * @return object
     */
    public function getOfferLogo()
    {
        return $this->offerLogo;
    }

    /**
     * @param object $offerLogo
     */
    public function setOfferLogo($offerLogo)
    {
        $this->offerLogo = $offerLogo;
    }

    /**
     * @return object
     */
    public function getOfferBackground()
    {
        return $this->offerBackground;
    }

    /**
     * @param object $offerBackground
     */
    public function setOfferBackground($offerBackground)
    {
        $this->offerBackground = $offerBackground;
    }

    /**
     * @return object
     */
    public function getThematicThumbnail()
    {
        return $this->thematicThumbnail;
    }

    /**
     * @param object $thematicThumbnail
     */
    public function setThematicThumbnail($thematicThumbnail)
    {
        $this->thematicThumbnail = $thematicThumbnail;
    }

    /**
     * @return object
     */
    public function getOfferDownload()
    {
        return $this->offerDownload;
    }

    /**
     * @param object $offerDownload
     */
    public function setOfferDownload($offerDownload)
    {
        $this->offerDownload = $offerDownload;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null === $this->file) {
            return;
        }

        $this->path = uniqid() . '.' . $this->file->guessExtension();
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir() . $this->path . '.' . $this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $this->file->move($this->getUploadRootDir(), $this->path);
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir() . $this->path;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFilename) and $this->path != 'securalliance-fond.jpg') {
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir()
    {
        return 'uploads/';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir() . $this->path;
    }

    public function getType()
    {
        if (preg_match('/\.(jpg|png|jpeg|gif)$/', $this->getPath())) {
            return 'image';
        } else if (preg_match('/\.(mp3|mov|mp4)$/', $this->getPath())) {
            return 'video';
        } else {
            return 'file';
        }
    }

    public function __clone()
    {
        var_dump('heloo');
        $this->id = null;
        $this->path = $this->duplicate();
    }

    public function duplicate()
    {
        $file = $this->getUploadRootDir() . $this->path;
        $newFile =  uniqid() . substr($this->path, strpos($this->path, '.'));
        copy($file, $this->getUploadRootDir() . $newFile);

        return $newFile;
    }
}

