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
 * Entity class for "case_hears" table
 */
#[Entity]
#[Table(name: "case_hears")]
class CaseHear extends AbstractEntity
{
    #[Id]
    #[Column(type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $id;

    #[Column(type: "string")]
    private string $melequtir;

    #[Column(name: "RANKe", type: "string")]
    private string $ranKe;

    #[Column(type: "string")]
    private string $name;

    #[Column(type: "string")]
    private string $ez;

    #[Column(type: "string")]
    private string $fileNumber;

    #[Column(type: "string")]
    private string $firdbet;

    #[Column(type: "string")]
    private string $chilotname;

    #[Column(type: "string")]
    private string $kirihidet;

    #[Column(type: "string")]
    private string $yekisaynet;

    #[Column(type: "text")]
    private string $keteroreason;

    #[Column(type: "string")]
    private string $sex;

    #[Column(type: "integer")]
    private int $tekesashbizat;

    #[Column(type: "datetime")]
    private DateTime $keterodate;

    #[Column(type: "text")]
    private string $keterodescription;

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

    public function getMelequtir(): string
    {
        return HtmlDecode($this->melequtir);
    }

    public function setMelequtir(string $value): static
    {
        $this->melequtir = RemoveXss($value);
        return $this;
    }

    public function getRanKe(): string
    {
        return HtmlDecode($this->ranKe);
    }

    public function setRanKe(string $value): static
    {
        $this->ranKe = RemoveXss($value);
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

    public function getEz(): string
    {
        return HtmlDecode($this->ez);
    }

    public function setEz(string $value): static
    {
        $this->ez = RemoveXss($value);
        return $this;
    }

    public function getFileNumber(): string
    {
        return HtmlDecode($this->fileNumber);
    }

    public function setFileNumber(string $value): static
    {
        $this->fileNumber = RemoveXss($value);
        return $this;
    }

    public function getFirdbet(): string
    {
        return HtmlDecode($this->firdbet);
    }

    public function setFirdbet(string $value): static
    {
        $this->firdbet = RemoveXss($value);
        return $this;
    }

    public function getChilotname(): string
    {
        return HtmlDecode($this->chilotname);
    }

    public function setChilotname(string $value): static
    {
        $this->chilotname = RemoveXss($value);
        return $this;
    }

    public function getKirihidet(): string
    {
        return HtmlDecode($this->kirihidet);
    }

    public function setKirihidet(string $value): static
    {
        $this->kirihidet = RemoveXss($value);
        return $this;
    }

    public function getYekisaynet(): string
    {
        return HtmlDecode($this->yekisaynet);
    }

    public function setYekisaynet(string $value): static
    {
        $this->yekisaynet = RemoveXss($value);
        return $this;
    }

    public function getKeteroreason(): string
    {
        return HtmlDecode($this->keteroreason);
    }

    public function setKeteroreason(string $value): static
    {
        $this->keteroreason = RemoveXss($value);
        return $this;
    }

    public function getSex(): string
    {
        return HtmlDecode($this->sex);
    }

    public function setSex(string $value): static
    {
        $this->sex = RemoveXss($value);
        return $this;
    }

    public function getTekesashbizat(): int
    {
        return $this->tekesashbizat;
    }

    public function setTekesashbizat(int $value): static
    {
        $this->tekesashbizat = $value;
        return $this;
    }

    public function getKeterodate(): DateTime
    {
        return $this->keterodate;
    }

    public function setKeterodate(DateTime $value): static
    {
        $this->keterodate = $value;
        return $this;
    }

    public function getKeterodescription(): string
    {
        return HtmlDecode($this->keterodescription);
    }

    public function setKeterodescription(string $value): static
    {
        $this->keterodescription = RemoveXss($value);
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
