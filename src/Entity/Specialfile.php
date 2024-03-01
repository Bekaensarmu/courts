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
 * Entity class for "specialfiles" table
 */
#[Entity]
#[Table(name: "specialfiles")]
class Specialfile extends AbstractEntity
{
    #[Column(name: "`ዕዝ`", options: ["name" => "ዕዝ"], type: "string", nullable: true)]
    private ?string $12D512Dd;

    #[Column(name: "`የችሎትስም`", options: ["name" => "የችሎትስም"], type: "string", nullable: true)]
    private ?string $12E8127D120E12751235121D;

    #[Column(name: "`የክርክሩሂደት`", options: ["name" => "የክርክሩሂደት"], type: "string", nullable: true)]
    private ?string $12E812Ad122D12Ad1229120212F01275;

    #[Column(name: "`የክስዓይነት`", options: ["name" => "የክስዓይነት"], type: "string", nullable: true)]
    private ?string $12E812Ad123512D312Ed12901275;

    #[Column(name: "`የቀጠሮምክንያት`", options: ["name" => "የቀጠሮምክንያት"], type: "string", nullable: true)]
    private ?string $12E812401320122E121D12Ad129512Eb1275;

    #[Column(name: "`የውሳኔዓይነት`", options: ["name" => "የውሳኔዓይነት"], type: "string", nullable: true)]
    private ?string $12E812Cd1233129412D312Ed12901275;

    #[Column(name: "`ማዕረግ`", options: ["name" => "ማዕረግ"], type: "string", nullable: true)]
    private ?string $121B12D51228130D;

    #[Column(name: "`ማብራርያ`", options: ["name" => "ማብራርያ"], type: "text", nullable: true)]
    private ?string $121B1265122B122D12Eb;

    #[Column(name: "`የተመዘገበበትቀን`", options: ["name" => "የተመዘገበበትቀን"], type: "datetime", nullable: true)]
    private ?DateTime $12E81270121812D8130812601260127512401295;

    #[Column(name: "`የተሻሻለበትቀን`", options: ["name" => "የተሻሻለበትቀን"], type: "datetime", nullable: true)]
    private ?DateTime $12E81270123B123B12081260127512401295;

    #[Column(name: "`መዝጋቢ`", options: ["name" => "መዝጋቢ"], type: "string")]
    private string $121812Dd130B1262;

    #[Id]
    #[Column(type: "bigint", unique: true)]
    #[GeneratedValue]
    private string $sid;

    public function get12D512Dd(): ?string
    {
        return HtmlDecode($this->12D512Dd);
    }

    public function set12D512Dd(?string $value): static
    {
        $this->12D512Dd = RemoveXss($value);
        return $this;
    }

    public function get12E8127D120E12751235121D(): ?string
    {
        return HtmlDecode($this->12E8127D120E12751235121D);
    }

    public function set12E8127D120E12751235121D(?string $value): static
    {
        $this->12E8127D120E12751235121D = RemoveXss($value);
        return $this;
    }

    public function get12E812Ad122D12Ad1229120212F01275(): ?string
    {
        return HtmlDecode($this->12E812Ad122D12Ad1229120212F01275);
    }

    public function set12E812Ad122D12Ad1229120212F01275(?string $value): static
    {
        $this->12E812Ad122D12Ad1229120212F01275 = RemoveXss($value);
        return $this;
    }

    public function get12E812Ad123512D312Ed12901275(): ?string
    {
        return HtmlDecode($this->12E812Ad123512D312Ed12901275);
    }

    public function set12E812Ad123512D312Ed12901275(?string $value): static
    {
        $this->12E812Ad123512D312Ed12901275 = RemoveXss($value);
        return $this;
    }

    public function get12E812401320122E121D12Ad129512Eb1275(): ?string
    {
        return HtmlDecode($this->12E812401320122E121D12Ad129512Eb1275);
    }

    public function set12E812401320122E121D12Ad129512Eb1275(?string $value): static
    {
        $this->12E812401320122E121D12Ad129512Eb1275 = RemoveXss($value);
        return $this;
    }

    public function get12E812Cd1233129412D312Ed12901275(): ?string
    {
        return HtmlDecode($this->12E812Cd1233129412D312Ed12901275);
    }

    public function set12E812Cd1233129412D312Ed12901275(?string $value): static
    {
        $this->12E812Cd1233129412D312Ed12901275 = RemoveXss($value);
        return $this;
    }

    public function get121B12D51228130D(): ?string
    {
        return HtmlDecode($this->121B12D51228130D);
    }

    public function set121B12D51228130D(?string $value): static
    {
        $this->121B12D51228130D = RemoveXss($value);
        return $this;
    }

    public function get121B1265122B122D12Eb(): ?string
    {
        return HtmlDecode($this->121B1265122B122D12Eb);
    }

    public function set121B1265122B122D12Eb(?string $value): static
    {
        $this->121B1265122B122D12Eb = RemoveXss($value);
        return $this;
    }

    public function get12E81270121812D8130812601260127512401295(): ?DateTime
    {
        return $this->12E81270121812D8130812601260127512401295;
    }

    public function set12E81270121812D8130812601260127512401295(?DateTime $value): static
    {
        $this->12E81270121812D8130812601260127512401295 = $value;
        return $this;
    }

    public function get12E81270123B123B12081260127512401295(): ?DateTime
    {
        return $this->12E81270123B123B12081260127512401295;
    }

    public function set12E81270123B123B12081260127512401295(?DateTime $value): static
    {
        $this->12E81270123B123B12081260127512401295 = $value;
        return $this;
    }

    public function get121812Dd130B1262(): string
    {
        return HtmlDecode($this->121812Dd130B1262);
    }

    public function set121812Dd130B1262(string $value): static
    {
        $this->121812Dd130B1262 = RemoveXss($value);
        return $this;
    }

    public function getSid(): string
    {
        return $this->sid;
    }

    public function setSid(string $value): static
    {
        $this->sid = $value;
        return $this;
    }
}
