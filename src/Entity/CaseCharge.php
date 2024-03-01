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
 * Entity class for "case_charges" table
 */
#[Entity]
#[Table(name: "case_charges")]
class CaseCharge extends AbstractEntity
{
    #[Id]
    #[Column(type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $id;

    #[Column(type: "string")]
    private string $deptName;

    #[Column(type: "string")]
    private string $mid;

    #[Column(name: "`rank`", options: ["name" => "rank"], type: "string")]
    private string $rank;

    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string")]
    private string $address;

    #[Column(type: "string")]
    private string $state;

    #[Column(type: "text")]
    private string $crimeDescription;

    #[Column(type: "datetime")]
    private DateTime $crimeDate;

    #[Column(name: "ChargeDate", type: "datetime")]
    private DateTime $chargeDate;

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

    public function getDeptName(): string
    {
        return HtmlDecode($this->deptName);
    }

    public function setDeptName(string $value): static
    {
        $this->deptName = RemoveXss($value);
        return $this;
    }

    public function getMid(): string
    {
        return HtmlDecode($this->mid);
    }

    public function setMid(string $value): static
    {
        $this->mid = RemoveXss($value);
        return $this;
    }

    public function getRank(): string
    {
        return HtmlDecode($this->rank);
    }

    public function setRank(string $value): static
    {
        $this->rank = RemoveXss($value);
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

    public function getAddress(): string
    {
        return HtmlDecode($this->address);
    }

    public function setAddress(string $value): static
    {
        $this->address = RemoveXss($value);
        return $this;
    }

    public function getState(): string
    {
        return HtmlDecode($this->state);
    }

    public function setState(string $value): static
    {
        $this->state = RemoveXss($value);
        return $this;
    }

    public function getCrimeDescription(): string
    {
        return HtmlDecode($this->crimeDescription);
    }

    public function setCrimeDescription(string $value): static
    {
        $this->crimeDescription = RemoveXss($value);
        return $this;
    }

    public function getCrimeDate(): DateTime
    {
        return $this->crimeDate;
    }

    public function setCrimeDate(DateTime $value): static
    {
        $this->crimeDate = $value;
        return $this;
    }

    public function getChargeDate(): DateTime
    {
        return $this->chargeDate;
    }

    public function setChargeDate(DateTime $value): static
    {
        $this->chargeDate = $value;
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
