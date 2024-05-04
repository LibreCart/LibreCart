<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\UrlKeyTrait;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource]
class Category extends BaseEntity
{
    use UrlKeyTrait;

    #[ORM\ManyToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    private ?self $parentCategory = null;

    private ?string $parentCategoryId = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CategoryTranslation::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $categoryTranslations;

    #[ORM\ManyToMany(Product::class, mappedBy:'categories')]
    private Collection $products;

    public function __construct()
    {
        $this->categoryTranslations = new ArrayCollection();
        $this->products = new ArrayCollection();    
    }

    public function getParentCategory(): ?self
    {
        return $this->parentCategory;
    }

    public function setParentCategory(?self $parentCategory)
    {
        if($this->parentCategory === $this){
            return;
        }

        $this->parentCategory = $parentCategory;
    }

    public function getParentCategoryId(): ?string{
        return $this->parentCategoryId;
    }

    public function setParentCategoryId(?string $parentCategoryId): void{
        $this->parentCategoryId = $parentCategoryId;
    }

    public function getCategoryTranslations(): Collection
    {
        return $this->categoryTranslations;
    }

    public function addCategoryTranslation(CategoryTranslation $categoryTranslation): static
    {
        if (!$this->categoryTranslations->contains($categoryTranslation)) {
            $this->categoryTranslations->add($categoryTranslation);
            $categoryTranslation->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryTranslation(CategoryTranslation $categoryTranslation): static
    {
        if ($this->categoryTranslations->removeElement($categoryTranslation)) {
            if ($categoryTranslation->getCategory() === $this) {
                $categoryTranslation->setCategory(null);
            }
        }

        return $this;
    }

    public function getProducts(): Collection 
    {
        return $this->products;
    }

    public function addProduct(Product $product): static 
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static 
    {
        if ($this->products->removeElement($product)) {
            $product->removeCategory($this);
        }

        return $this;
    }
}
