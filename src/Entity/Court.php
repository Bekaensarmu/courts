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
 * Entity class for "courts" table
 */
#[Entity]
#[Table(name: "courts")]
class Court extends AbstractEntity
{
    #[Id]
    #[Column(type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $id;

    #[Column(name: "courtID", type: "string")]
    private string $courtId;

    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string")]
    private string $workType;

    #[Column(type: "integer")]
    private int $yetefekedebizat;

    #[Column(type: "integer")]
    private int $yale;

    #[Column(type: "integer")]
    private int $yegodele;

    #[Column(type: "text")]
    private string $description;

    #[Column(name: "created_at", type: "datetime", nullable: true)]
    private ?DateTime $createdAt;

    #[Column(name: "updated_at", type: "datetime", nullable: true)]
    private ?DateTime $updatedAt;

    #[Column(name: "updated_by", type: "integer")]
    private int $updatedBy;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getCourtId(): string
    {
        return HtmlDecode($this->courtId);
    }

    public function setCourtId(string $value): static
    {
        $this->courtId = RemoveXss($value);
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

    public function getWorkType(): string
    {
        return HtmlDecode($this->workType);
    }

    public function setWorkType(string $value): static
    {
        $this->workType = RemoveXss($value);
        return $this;
    }

    public function getYetefekedebizat(): int
    {
        return $this->yetefekedebizat;
    }

    public function setYetefekedebizat(int $value): static
    {
        $this->yetefekedebizat = $value;
        return $this;
    }

    public function getYale(): int
    {
        return $this->yale;
    }

    public function setYale(int $value): static
    {
        $this->yale = $value;
        return $this;
    }

    public function getYegodele(): int
    {
        return $this->yegodele;
    }

    public function setYegodele(int $value): static
    {
        $this->yegodele = $value;
        return $this;
    }

    public function getDescription(): string
    {
        return HtmlDecode($this->description);
    }

    public function setDescription(string $value): static
    {
        $this->description = RemoveXss($value);
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

    public function getUpdatedBy(): int
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(int $value): static
    {
        $this->updatedBy = $value;
        return $this;
    }
}
