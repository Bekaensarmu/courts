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
 * Entity class for "ተከሳሽ" table
 */
#[Entity]
#[Table(name: "`ተከሳሽ`")]
class ተከሳሽ extends AbstractEntity
{
    #[Column(name: "`Count(case_hears.address)`", options: ["name" => "Count(case_hears.address)"], type: "bigint", nullable: true)]
    private ?string $countcaseHearsaddress;

    public function getCountcaseHearsaddress(): ?string
    {
        return $this->countcaseHearsaddress;
    }

    public function setCountcaseHearsaddress(?string $value): static
    {
        $this->countcaseHearsaddress = $value;
        return $this;
    }
}
