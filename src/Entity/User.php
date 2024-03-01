<?php

namespace PHPMaker2024\project2\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2024\project2\AbstractEntity;
use PHPMaker2024\project2\AdvancedSecurity;
use PHPMaker2024\project2\UserProfile;
use function PHPMaker2024\project2\Config;
use function PHPMaker2024\project2\EntityManager;
use function PHPMaker2024\project2\RemoveXss;
use function PHPMaker2024\project2\HtmlDecode;
use function PHPMaker2024\project2\EncryptPassword;

/**
 * Entity class for "users" table
 */
#[Entity]
#[Table(name: "users")]
class User extends AbstractEntity
{
    #[Id]
    #[Column(type: "bigint", unique: true)]
    private string $id;

    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string", unique: true)]
    private string $email;

    #[Column(type: "string")]
    private string $password;

    #[Column(type: "text", nullable: true)]
    private ?string $description;

    #[Column(name: "current_team_id", type: "bigint", nullable: true)]
    private ?string $currentTeamId;

    #[Column(name: "profile_photo_path", type: "text", nullable: true)]
    private ?string $profilePhotoPath;

    #[Column(name: "created_at", type: "datetime", nullable: true)]
    private ?DateTime $createdAt;

    #[Column(name: "updated_at", type: "datetime", nullable: true)]
    private ?DateTime $updatedAt;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getName(): string
    {
        return HtmlDecode($this->name);
    }

    public function setName(string $value): static
    {
        $this->name = RemoveXss($value);
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $value): static
    {
        $this->email = $value;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $value): static
    {
        $this->password = EncryptPassword(Config("CASE_SENSITIVE_PASSWORD") ? $value : strtolower($value));
        return $this;
    }

    public function getDescription(): ?string
    {
        return HtmlDecode($this->description);
    }

    public function setDescription(?string $value): static
    {
        $this->description = RemoveXss($value);
        return $this;
    }

    public function getCurrentTeamId(): ?string
    {
        return $this->currentTeamId;
    }

    public function setCurrentTeamId(?string $value): static
    {
        $this->currentTeamId = $value;
        return $this;
    }

    public function getProfilePhotoPath(): ?string
    {
        return HtmlDecode($this->profilePhotoPath);
    }

    public function setProfilePhotoPath(?string $value): static
    {
        $this->profilePhotoPath = RemoveXss($value);
        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $value): static
    {
        $this->createdAt = $value;
        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $value): static
    {
        $this->updatedAt = $value;
        return $this;
    }

    // Get login arguments
    public function getLoginArguments(): array
    {
        return [
            "userName" => $this->get('email'),
            "userId" => $this->get('email'),
            "parentUserId" => $this->get('email'),
            "userLevel" => $this->get('current_team_id') ?? AdvancedSecurity::ANONYMOUS_USER_LEVEL_ID,
            "userPrimaryKey" => $this->get('id'),
        ];
    }
}
