<?php

namespace App\Entity\Moderation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModerationRepository")
 * @ORM\Table(name="0_moderation")
 * @ORM\HasLifecycleCallbacks()
 */
class Moderation
{
    const UNPAYED = '0';
    const PAYED = '1';

    const TYPE_GOOD = 'good';
    const TYPE_NEW = 'new';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="moderation_id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="payed", type="string", columnDefinition="ENUM('0','1')", length=1, options={"default" : 0})
     */
    private $payed;

    /**
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @ORM\Column(name="place_id", type="string", length=70, nullable=true)
     */
    private $placeId;

    /**
     * @ORM\Column(name="place_address", type="string", length=255, nullable=true)
     */
    private $placeAddress;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM(('good', 'new')", length=10, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(name="business_name", type="string", length=255, nullable=true)
     */
    private $businessName;

    /**
     * @ORM\Column(name="1_cid", type="string", length=255, nullable=true)
     */
    private $cid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $publishAccount;

    /**
     * @ORM\Column(name="token", type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Moderation\Panoramas", mappedBy="moderation", cascade={"persist", "remove"})
     * @ORM\OrderBy({"folderId" = "ASC"})
     */
    private $panoramas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayed(): ?bool
    {
        return $this->payed;
    }

    public function setPayed(bool $payed): self
    {
        $this->payed = $payed;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPlaceId(): ?bool
    {
        return $this->placeId;
    }

    public function setPlaceId(?int $placeId): self
    {
        $this->placeId = $placeId;

        return $this;
    }

    public function getPlaceAddress(): ?string
    {
        return $this->placeAddress;
    }

    public function setPlaceAddress(?string $placeAddress): self
    {
        $this->placeAddress = $placeAddress;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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
     * Get update time
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    public function setBusinessName(?string $businessName): self
    {
        $this->businessName = $businessName;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getCid(): ?string
    {
        return $this->cid;
    }

    public function setCid(?string $cid): self
    {
        $this->cid = $cid;

        return $this;
    }

    public function getPublishAccount(): ?string
    {
        return $this->publishAccount;
    }

    public function setPublishAccount(?string $publishAccount): self
    {
        $this->publishAccount = $publishAccount;

        return $this;
    }

    public function getPanoramas(): ?array
    {
        return $this->panoramas;
    }

    public function setPanoramas(?array $panoramas): self
    {
        $this->panoramas = $panoramas;

        return $this;
    }

    /**
     * Triggered on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * Triggered on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }
}
