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
 * Entity class for "esregna" table
 */
#[Entity]
#[Table(name: "esregna")]
class Esregna extends AbstractEntity
{
    #[Column(type: "string", nullable: true)]
    private ?string $mid;

    #[Column(name: "`rank`", options: ["name" => "rank"], type: "string", nullable: true)]
    private ?string $rank;

    #[Column(type: "string", nullable: true)]
    private ?string $name;

    #[Column(type: "string", nullable: true)]
    private ?string $deptName;

    #[Column(name: "ChargeDate", type: "datetime", nullable: true)]
    private ?DateTime $chargeDate;

    #[Column(name: "created_at", type: "datetime")]
    private DateTime $createdAt;

    public function getMid(): ?string
    {
        return HtmlDecode($this->mid);
    }

    public function setMid(?string $value): static
    {
        $this->mid = RemoveXss($value);
        return $this;
    }

    public function getRank(): ?string
    {
        return HtmlDecode($this->rank);
    }

    public function setRank(?string $value): static
    {
        $this->rank = RemoveXss($value);
        return $this;
    }

    public function getName(): ?string
    {
        return HtmlDecode($this->name);
    }

    public function setName(?string $value): static
    {
        $this->name = RemoveXss($value);
        return $this;
    }

    public function getDeptName(): ?string
    {
        return HtmlDecode($this->deptName);
    }

    public function setDeptName(?string $value): static
    {
        $this->deptName = RemoveXss($value);
        return $this;
    }

    public function getChargeDate(): ?DateTime
    {
        return $this->chargeDate;
    }

    public function setChargeDate(?DateTime $value): static
    {
        $this->chargeDate = $value;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $value): static
    {
        $this->createdAt = $value;
        return $this;
    }
}
