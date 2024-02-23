<?php

namespace App\Entity;

use App\Entity\Traits\TimestampAbleTrait;
use App\Entity\Traits\TranslateAbleTrait;
use App\Entity\Traits\UuidTrait;
use App\Repository\CategoryTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryTranslationRepository::class)]
class CategoryTranslation
{
    use UuidTrait;
    use TranslateAbleTrait;
    use TimestampAbleTrait;

    #[ORM\ManyToOne(inversedBy: 'categoryTranslations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

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
