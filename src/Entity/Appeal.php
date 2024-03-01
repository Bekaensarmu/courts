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
 * Entity class for "appeal" table
 */
#[Entity]
#[Table(name: "appeal")]
class Appeal extends AbstractEntity
{
    #[Column(name: "AppealID", type: "string")]
    private string $appealId;

    #[Column(type: "datetime")]
    private DateTime $appealDate;

    #[Column(type: "string")]
    private string $mid;

    #[Column(name: "`rank`", options: ["name" => "rank"], type: "string")]
    private string $rank;

    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string")]
    private string $deptName;

    #[Column(type: "string")]
    private string $halafinet;

    #[Column(type: "string")]
    private string $crimstate;

    #[Column(name: "Description", type: "text")]
    private string $description;

    #[Column(type: "string")]
    private string $midib;

    #[Column(type: "string")]
    private string $appealask;

    #[Column(name: "AppealDescription", type: "text")]
    private string $appealDescription;

    #[Column(type: "string")]
    private string $appealDecision;

    #[Column(name: "created_at", type: "datetime", nullable: true)]
    private ?DateTime $createdAt;

    #[Column(type: "datetime")]
    private DateTime $crimeDate;

    #[Column(name: "updated_at", type: "datetime", nullable: true)]
    private ?DateTime $updatedAt;

    #[Column(name: "updated_by", type: "integer")]
    private int $updatedBy;

    #[Id]
    #[Column(type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $id;

    public function getAppealId(): string
    {
        return HtmlDecode($this->appealId);
    }

    public function setAppealId(string $value): static
    {
        $this->appealId = RemoveXss($value);
        return $this;
    }

    public function getAppealDate(): DateTime
    {
        return $this->appealDate;
    }

    public function setAppealDate(DateTime $value): static
    {
        $this->appealDate = $value;
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

    public function getDeptName(): string
    {
        return HtmlDecode($this->deptName);
    }

    public function setDeptName(string $value): static
    {
        $this->deptName = RemoveXss($value);
        return $this;
    }

    public function getHalafinet(): string
    {
        return HtmlDecode($this->halafinet);
    }

    public function setHalafinet(string $value): static
    {
        $this->halafinet = RemoveXss($value);
        return $this;
    }

    public function getCrimstate(): string
    {
        return HtmlDecode($this->crimstate);
    }

    public function setCrimstate(string $value): static
    {
        $this->crimstate = RemoveXss($value);
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

    public function getMidib(): string
    {
        return HtmlDecode($this->midib);
    }

    public function setMidib(string $value): static
    {
        $this->midib = RemoveXss($value);
        return $this;
    }

    public function getAppealask(): string
    {
        return HtmlDecode($this->appealask);
    }

    public function setAppealask(string $value): static
    {
        $this->appealask = RemoveXss($value);
        return $this;
    }

    public function getAppealDescription(): string
    {
        return HtmlDecode($this->appealDescription);
    }

    public function setAppealDescription(string $value): static
    {
        $this->appealDescription = RemoveXss($value);
        return $this;
    }

    public function getAppealDecision(): string
    {
        return HtmlDecode($this->appealDecision);
    }

    public function setAppealDecision(string $value): static
    {
        $this->appealDecision = RemoveXss($value);
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

    public function getCrimeDate(): DateTime
    {
        return $this->crimeDate;
    }

    public function setCrimeDate(DateTime $value): static
    {
        $this->crimeDate = $value;
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

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $value): static
    {
        $this->id = $value;
        return $this;
    }
}
