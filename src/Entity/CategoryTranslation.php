<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\UuidTrait;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\TimestampAbleTrait;
use App\Entity\Traits\TranslateAbleTrait;
use App\Repository\CategoryTranslationRepository;

#[ORM\Entity(repositoryClass: CategoryTranslationRepository::class)]
#[ORM\UniqueConstraint(columns:['category_id', 'locale'])]
#[ApiResource()]
class CategoryTranslation
{
    use UuidTrait;
    use TranslateAbleTrait;
    use TimestampAbleTrait;

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
