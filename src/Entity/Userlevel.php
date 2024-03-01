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
 * Entity class for "userlevels" table
 */
#[Entity]
#[Table(name: "userlevels")]
class Userlevel extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    private int $userlevelid;

    #[Column(type: "string")]
    private string $userlevelname;

    public function getUserlevelid(): int
    {
        return $this->userlevelid;
    }

    public function setUserlevelid(int $value): static
    {
        $this->userlevelid = $value;
        return $this;
    }

    public function getUserlevelname(): string
    {
        return HtmlDecode($this->userlevelname);
    }

    public function setUserlevelname(string $value): static
    {
        $this->userlevelname = RemoveXss($value);
        return $this;
    }
}
