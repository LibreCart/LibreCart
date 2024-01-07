<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource()]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductTranslation::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $productTranslations;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 13)]
    private ?string $ean = null;

    #[ORM\Column(nullable: true)]
    private ?int $stock = null;


    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->productTranslations = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable('now');
        $this->updated_at = new \DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ProductTranslation>
     */
    public function getProductTranslations(): Collection
    {
        return $this->productTranslations;
    }

    public function addProductTranslation(ProductTranslation $productTranslation): static
    {
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTimeImmutable('now'));
    }
}
