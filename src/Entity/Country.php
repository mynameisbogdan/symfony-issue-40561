<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 * @ORM\Table(name="symfony_demo_country")
 * @UniqueEntity(fields={"code"}, errorPath="code", message="country.country_unique")
 */
class Country
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2, unique=true)
     *
     * @Assert\NotBlank(message="country.blank")
     * @Assert\Country()
     */
    private $code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getName(?string $locale = null): ?string
    {
        return Countries::getName($this->code, $locale);
    }
}
