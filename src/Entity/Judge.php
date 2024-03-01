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
 * Entity class for "judges" table
 */
#[Entity]
#[Table(name: "judges")]
class Judge extends AbstractEntity
{
    #[Id]
    #[Column(type: "bigint", unique: true)]
    private string $id;

    #[Column(name: "judgeID", type: "string")]
    private string $judgeId;

    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string")]
    private string $courtTyep;

    #[Column(name: "Address", type: "string")]
    private string $address;

    #[Column(type: "string")]
    private string $state;

    #[Column(name: "Emptype", type: "string")]
    private string $emptype;

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

    public function getJudgeId(): string
    {
        return HtmlDecode($this->judgeId);
    }

    public function setJudgeId(string $value): static
    {
        $this->judgeId = RemoveXss($value);
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

    public function getCourtTyep(): string
    {
        return HtmlDecode($this->courtTyep);
    }

    public function setCourtTyep(string $value): static
    {
        $this->courtTyep = RemoveXss($value);
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

    public function getEmptype(): string
    {
        return HtmlDecode($this->emptype);
    }

    public function setEmptype(string $value): static
    {
        $this->emptype = RemoveXss($value);
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
