<?php

namespace App\Entity\Traits;

use App\Enum\LocaleEnum;
use Doctrine\ORM\Mapping as ORM;

trait TranslateAbleTrait 
{
    #[ORM\Column(length: 255, nullable: false, type: 'string')]
    private string $locale = LocaleEnum::en_US->name;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = LocaleEnum::getLocaleByString($locale)->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    
    public function __toString()
    {
        return $this->locale;
    }
}