<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    const INACTIVE = '0';
    const IS_ACTIVE = '1';

    const FB_LOGIN = '1';
    const GOOGLE_LOGIN = '2';

    const NON_AFFILIATED = '0';
    const IS_AFFILIATED = '1';

    const UNSUBSCRIBED = 0;
    const SUBSCRIBED = 1;

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    const TYPE_SINGLE = '1';
    const TYPE_AGENCY = '2';
    const FB_ADMIN = '3';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="user_id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="is_active", type="string", columnDefinition="ENUM('0','1')", length=1, nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(name="subscribtion", type="boolean", options={"default" : 100})
     */
    private $subscription;

    /**
     * @ORM\Column(name="plugin_version", type="string", length=3, nullable=true)
     */
    private $pluginVersion;

    /**
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(name="user_name", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    private $googleId;

    /**
     * @ORM\Column(name="google_plus_page", type="string", length=255, nullable=true)
     */
    private $googlePlusPage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('male','female')", length=10, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(name="verified_email", type="string", columnDefinition="ENUM('0','1')", length=1, nullable=true, options={"default" : 1})
     */
    private $verifiedEmail;

    /**
     * @ORM\Column(name="is_affiliated", type="string", columnDefinition="ENUM('0','1')", length=1, nullable=true, options={"default" : 0})
     */
    private $isAffiliated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deactivated", type="datetime", nullable=true)
     */
    private $deactivatedAt;

    /**
     * @ORM\Column(name="user_type", type="string", columnDefinition="ENUM('1', '2', '3')", length=1, nullable=true, options={"default" : 1})
     */
    private $userType;

    /**
     * @ORM\Column(name="test", type="string", columnDefinition="ENUM('0', '1', '2', '3')", length=1, nullable=true, options={"default" : 0})
     */
    private $test;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Main\UserTokens", mappedBy="user", cascade={"persist", "remove"})
     */
    private $userToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getSubscription(): ?bool
    {
        return $this->subscription;
    }

    public function setSubscription(bool $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getIsAffiliated(): ?bool
    {
        return $this->isAffiliated;
    }

    public function setIsAffiliated(bool $isAffiliated): self
    {
        $this->isAffiliated = $isAffiliated;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->googleId;
    }

    public function setGoogleId(string $googleId): self
    {
        $this->googleId = $googleId;

        return $this;
    }

    public function getGooglePlusPage(): ?string
    {
        return $this->googlePlusPage;
    }

    public function setGooglePlusPage(string $googlePlusPage): self
    {
        $this->googlePlusPage = $googlePlusPage;

        return $this;
    }

    public function getPluginVersion(): ?string
    {
        return $this->pluginVersion;
    }

    public function setPluginVersion(string $pluginVersion): self
    {
        $this->pluginVersion = $pluginVersion;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getVerifiedEmail(): ?bool
    {
        return $this->verifiedEmail;
    }

    public function setVerifiedEmail(bool $verifiedEmail): self
    {
        $this->verifiedEmail = $verifiedEmail;

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
     * Set deactivated date
     *
     * @param $deactivatedAt
     *
     * @return self
     */
    public function setDeactivatedAt($deactivatedAt)
    {
        $this->deactivatedAt = $deactivatedAt;
        return $this;
    }

    /**
     * Get deactivated date
     *
     * @return \DateTime
     */
    public function getDeactivatedAt()
    {
        return $this->deactivatedAt;
    }

    public function getUserType(): ?string
    {
        return $this->userType;
    }

    public function setUserType(?string $userType): self
    {
        $this->userType = $userType;

        return $this;
    }

    public function getTest(): ?string
    {
        return $this->test;
    }

    public function setTest(?string $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function getUserToken(): ?UserTokens
    {
        return $this->userToken;
    }

    public function setUserToken(UserTokens $userToken): self
    {
        $this->userToken = $userToken;

        // set the owning side of the relation if necessary
        if ($this !== $userToken->getUser()) {
            $userToken->setUser($this);
        }

        return $this;
    }

    /**
     * Triggered on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return mixed The user roles
     */
    public function getRoles()
    {
        return [
            'ROLE_ADMIN'
        ];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
