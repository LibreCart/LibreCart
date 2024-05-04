<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TranslateAbleTrait;
use App\Repository\ProductTranslationRepository;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProductTranslationRepository::class)]
#[ORM\UniqueConstraint(columns:['product_id', 'locale'])]
class ProductTranslation extends BaseEntity
{ 
    use TranslateAbleTrait;

    #[ORM\ManyToOne(inversedBy: 'productTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

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
