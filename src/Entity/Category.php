<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\UuidTrait;
use App\Entity\Traits\UrlKeyTrait;
use App\Repository\CategoryRepository;
use App\Entity\Traits\TimestampAbleTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    use UuidTrait;
    use UrlKeyTrait;
    use TimestampAbleTrait;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CategoryTranslation::class, orphanRemoval: true)]
    private ?Collection $categoryTranslations = null;

    #[ORM\OneToOne(targetEntity: self::class, cascade: ['persist', 'remove'])]
    private ?self $parentCategory = null;

    public function getCategoryTranslations(): ?Collection
    {
        return $this->categoryTranslations;
    }

    public function addCategoryTranslation(CategoryTranslation $categoryTranslation): static
    {
        if (!$this->categoryTranslations) {
            $this->categoryTranslations = new ArrayCollection();
        }

        if (!$this->categoryTranslations->contains($categoryTranslation)) {
            $this->categoryTranslations->add($categoryTranslation);
            $categoryTranslation->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryTranslation(CategoryTranslation $categoryTranslation): static
    {
        if ($this->categoryTranslations->removeElement($categoryTranslation)) {
            // set the owning side to null (unless already changed)
            if ($categoryTranslation->getCategory() === $this) {
                $categoryTranslation->setCategory(null);
            }
        }

        return $this;
    }

    public function getParentCategory(): ?self
    {
        return $this->parentCategory;
    }

    public function setParentCategory(?self $parentCategory): static
    {
        $this->parentCategory = $parentCategory;

        return $this;
    }
}
