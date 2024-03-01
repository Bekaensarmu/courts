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
 * Entity class for "wesane" table
 */
#[Entity]
#[Table(name: "wesane")]
class Wesane extends AbstractEntity
{
    #[Column(type: "string", nullable: true)]
    private ?string $address;

    #[Column(type: "string", nullable: true)]
    private ?string $state;

    #[Column(type: "string", nullable: true)]
    private ?string $status;

    #[Column(type: "string", nullable: true)]
    private ?string $deptname;

    #[Column(name: "updated_at", type: "datetime")]
    private DateTime $updatedAt;

    public function getAddress(): ?string
    {
        return HtmlDecode($this->address);
    }

    public function setAddress(?string $value): static
    {
        $this->address = RemoveXss($value);
        return $this;
    }

    public function getState(): ?string
    {
        return HtmlDecode($this->state);
    }

    public function setState(?string $value): static
    {
        $this->state = RemoveXss($value);
        return $this;
    }

    public function getStatus(): ?string
    {
        return HtmlDecode($this->status);
    }

    public function setStatus(?string $value): static
    {
        $this->status = RemoveXss($value);
        return $this;
    }

    public function getDeptname(): ?string
    {
        return HtmlDecode($this->deptname);
    }

    public function setDeptname(?string $value): static
    {
        $this->deptname = RemoveXss($value);
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $value): static
    {
        $this->updatedAt = $value;
        return $this;
    }
}
