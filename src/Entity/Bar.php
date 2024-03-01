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
 * Entity class for "bars" table
 */
#[Entity]
#[Table(name: "bars")]
class Bar extends AbstractEntity
{
    #[Id]
    #[Column(type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $id;

    #[Column(type: "string")]
    private string $address;

    #[Column(type: "string")]
    private string $state;

    #[Column(type: "string")]
    private string $location;

    #[Column(type: "string")]
    private string $dihiresira;

    #[Column(type: "string")]
    private string $genzebtype;

    #[Column(type: "decimal")]
    private string $birramount;

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

    public function getLocation(): string
    {
        return HtmlDecode($this->location);
    }

    public function setLocation(string $value): static
    {
        $this->location = RemoveXss($value);
        return $this;
    }

    public function getDihiresira(): string
    {
        return HtmlDecode($this->dihiresira);
    }

    public function setDihiresira(string $value): static
    {
        $this->dihiresira = RemoveXss($value);
        return $this;
    }

    public function getGenzebtype(): string
    {
        return HtmlDecode($this->genzebtype);
    }

    public function setGenzebtype(string $value): static
    {
        $this->genzebtype = RemoveXss($value);
        return $this;
    }

    public function getBirramount(): string
    {
        return $this->birramount;
    }

    public function setBirramount(string $value): static
    {
        $this->birramount = $value;
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
