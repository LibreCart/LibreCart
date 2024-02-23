<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\UuidTrait;
use App\Entity\Traits\UrlKeyTrait;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use App\Entity\Traits\TimestampAbleTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource()]
class Product
{
    use UuidTrait;
    use UrlKeyTrait;
    use TimestampAbleTrait;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductTranslation::class, orphanRemoval: true, cascade: ['persist'])]
    private ?Collection $productTranslations = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 13)]
    private ?string $ean = null;

    #[ORM\Column(nullable: true)]
    private ?int $stock = null;

    public function getProductTranslations(): ?Collection
    {
        return $this->productTranslations;
    }

    public function addProductTranslation(ProductTranslation $productTranslation): static
    {
        if (!$this->productTranslations) {
            $this->productTranslations = new ArrayCollection();
        }
        
        if (!$this->productTranslations->contains($productTranslation)) {
            $this->productTranslations->add($productTranslation);
            $productTranslation->setProduct($this);
        }

        return $this;
    }

    public function removeProductTranslation(ProductTranslation $productTranslation): static
    {
        if ($this->productTranslations->removeElement($productTranslation)) {
            // set the owning side to null (unless already changed)
            if ($productTranslation->getProduct() === $this) {
                $productTranslation->setProduct(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(string $ean): static
    {
        $this->ean = $ean;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }
}
