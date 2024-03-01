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
 * Entity class for "decisions" table
 */
#[Entity]
#[Table(name: "decisions")]
class Decision extends AbstractEntity
{
    #[Id]
    #[Column(type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $id;

    #[Column(type: "datetime")]
    private DateTime $decisionDate;

    #[Column(name: "Decisiontype", type: "string")]
    private string $decisiontype;

    #[Column(type: "string")]
    private string $kistype;

    #[Column(type: "string")]
    private string $ez;

    #[Column(type: "string")]
    private string $chilot;

    #[Column(name: "Description", type: "text")]
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

    public function getDecisionDate(): DateTime
    {
        return $this->decisionDate;
    }

    public function setDecisionDate(DateTime $value): static
    {
        $this->decisionDate = $value;
        return $this;
    }

    public function getDecisiontype(): string
    {
        return HtmlDecode($this->decisiontype);
    }

    public function setDecisiontype(string $value): static
    {
        $this->decisiontype = RemoveXss($value);
        return $this;
    }

    public function getKistype(): string
    {
        return HtmlDecode($this->kistype);
    }

    public function setKistype(string $value): static
    {
        $this->kistype = RemoveXss($value);
        return $this;
    }

    public function getEz(): string
    {
        return HtmlDecode($this->ez);
    }

    public function setEz(string $value): static
    {
        $this->ez = RemoveXss($value);
        return $this;
    }

    public function getChilot(): string
    {
        return HtmlDecode($this->chilot);
    }

    public function setChilot(string $value): static
    {
        $this->chilot = RemoveXss($value);
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
