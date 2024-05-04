<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TranslateAbleTrait;
use App\Repository\CategoryTranslationRepository;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CategoryTranslationRepository::class)]
#[ORM\UniqueConstraint(columns:['category_id', 'locale'])]
class CategoryTranslation extends BaseEntity
{
    use TranslateAbleTrait;

    #[ORM\ManyToOne(inversedBy: 'categoryTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
