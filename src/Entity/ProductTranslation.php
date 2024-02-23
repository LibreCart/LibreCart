<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\UuidTrait;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\TimestampAbleTrait;
use App\Entity\Traits\TranslateAbleTrait;
use App\Repository\ProductTranslationRepository;

#[ORM\Entity(repositoryClass: ProductTranslationRepository::class)]
#[ORM\UniqueConstraint(columns:['product_id', 'locale'])]
#[ApiResource()]
class ProductTranslation
{
    use UuidTrait;
    use TranslateAbleTrait;
    use TimestampAbleTrait;

    #[ORM\ManyToOne(inversedBy: 'productTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    public function __toString()
    {
        return $this->locale;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
