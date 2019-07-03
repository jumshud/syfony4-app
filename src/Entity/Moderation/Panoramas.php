<?php

namespace App\Entity\Moderation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PanoramasRepository")
 * @ORM\Table(name="4_panoramas")
 * @ORM\HasLifecycleCallbacks()
 */
class Panoramas
{
    const PANO_TYPE65 = '65';
    const PANO_TYPE66 = '66';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Moderation\Moderation", inversedBy="panorama", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="moderation_id", referencedColumnName="moderation_id", nullable=false)
     */
    private $moderation;

    /**
     * @ORM\Column(name="thumb_local_path", type="string", length=255, nullable=true)
     */
    private $thumbLocalPath;

    /**
     * @ORM\Column(name="full_local_path", type="string", length=255, nullable=true)
     */
    private $fullLocalPath;

    /**
     * @ORM\Column(name="thumb_size", type="integer", nullable=true)
     */
    private $thumbSize;

    /**
     * @ORM\Column(name="folder_id", type="integer", nullable=true)
     */
    private $folderId;

    /**
     * @ORM\Column(name="version", type="integer", length=3, nullable=true, options={"default": 1})
     */
    private $version;

    /**
     * @ORM\Column(name="6_pano_type", type="string", columnDefinition="ENUM(('65', '66')", length=2, nullable=true)
     */
    private $panoType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=true)
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModeration(): ?Moderation
    {
        return $this->moderation;
    }

    public function setModeration(Moderation $moderation): self
    {
        $this->moderation = $moderation;

        return $this;
    }

    public function getThumbLocalPath(): ?string
    {
        return $this->thumbLocalPath;
    }

    public function setThumbLocalPath(?string $thumbLocalPath): self
    {
        $this->thumbLocalPath = $thumbLocalPath;

        return $this;
    }

    public function getFullLocalPath(): ?string
    {
        return $this->fullLocalPath;
    }

    public function setFullLocalPath(?string $fullLocalPath): self
    {
        $this->fullLocalPath = $fullLocalPath;

        return $this;
    }

    public function getThumbSize(): ?int
    {
        return $this->thumbSize;
    }

    public function setThumbSize(?int $thumbSize): self
    {
        $this->thumbSize = $thumbSize;

        return $this;
    }

    public function getFolderId(): ?int
    {
        return $this->folderId;
    }

    public function setFolderId(?int $folderId): self
    {
        $this->folderId = $folderId;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(?int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getPanoType(): ?string
    {
        return $this->panoType;
    }

    public function setPanoType(?string $panoType): self
    {
        $this->version = $panoType;

        return $this;
    }

    /**
     * Set created
     *
     * @param $createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Triggered on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }
}
