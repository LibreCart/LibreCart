<?php 

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use App\Entity\Traits\UuidTrait;
use App\Repository\UrlMappingRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity(repositoryClass: UrlMappingRepository::class)]
class UrlMapping
{
    #[ORM\Id]
    #[ORM\Column(length: 255, nullable: false, type: 'string', unique: true)]
    private string $urlKey;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $entityType;

    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $entityId;

    public function getUrlKey(): string 
    {
        return $this->urlKey ?? '';
    }

    public function setUrlKey(string $urlKey): static 
    {
        $this->urlKey = $urlKey;
        
        return $this;
    }

    public function getEntityType(): string 
    {
        return $this->entityType;
    }

    public function setEntityType(string $entityType): static 
    {
        $this->entityType = $entityType;
        
        return $this;
    }

    public function getEntityId(): Uuid 
    {
        return $this->entityId;
    }

    public function setEntityId(Uuid $entityId): static 
    {
        $this->entityId = $entityId;
        
        return $this;
    }
}