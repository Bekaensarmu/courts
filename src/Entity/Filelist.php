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
 * Entity class for "filelist" table
 */
#[Entity]
#[Table(name: "filelist")]
class Filelist extends AbstractEntity
{
    #[Column(type: "string")]
    private string $typeofcharge;

    #[Column(name: "CaseID", type: "string")]
    private string $caseId;

    #[Column(type: "string")]
    private string $address;

    #[Column(type: "string")]
    private string $state;

    #[Column(type: "string")]
    private string $deptname;

    #[Column(type: "string")]
    private string $casename;

    #[Column(type: "string")]
    private string $fileNumber;

    #[Column(type: "string")]
    private string $location;

    #[Column(type: "string")]
    private string $status;

    #[Column(type: "text")]
    private string $description;

    public function getTypeofcharge(): string
    {
        return HtmlDecode($this->typeofcharge);
    }

    public function setTypeofcharge(string $value): static
    {
        $this->typeofcharge = RemoveXss($value);
        return $this;
    }

    public function getCaseId(): string
    {
        return HtmlDecode($this->caseId);
    }

    public function setCaseId(string $value): static
    {
        $this->caseId = RemoveXss($value);
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

    public function getDeptname(): string
    {
        return HtmlDecode($this->deptname);
    }

    public function setDeptname(string $value): static
    {
        $this->deptname = RemoveXss($value);
        return $this;
    }

    public function getCasename(): string
    {
        return HtmlDecode($this->casename);
    }

    public function setCasename(string $value): static
    {
        $this->casename = RemoveXss($value);
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

    public function getLocation(): string
    {
        return HtmlDecode($this->location);
    }

    public function setLocation(string $value): static
    {
        $this->location = RemoveXss($value);
        return $this;
    }

    public function getStatus(): string
    {
        return HtmlDecode($this->status);
    }

    public function setStatus(string $value): static
    {
        $this->status = RemoveXss($value);
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
}
