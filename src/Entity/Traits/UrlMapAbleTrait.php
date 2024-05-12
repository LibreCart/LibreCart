<?php 

namespace App\Entity\Traits;

use App\Entity\Product;
use App\Entity\UrlMapping;
use Doctrine\ORM\Mapping as ORM;

trait UrlMapAbleTrait 
{
    #[ORM\OneToOne(targetEntity: UrlMapping::class, cascade:['persist', 'remove', 'merge'], mappedBy: 'entityId')]
    #[ORM\JoinColumn(name: 'url_mapping_key', referencedColumnName: 'url_key', nullable: true)]
    private ?UrlMapping $urlMapping = null;

    public function getUrlMapping(): ?UrlMapping {
        return $this->urlMapping;
    }

    public function setUrlMapping(UrlMapping $urlMapping): static {
        $this->urlMapping = $urlMapping;

        return $this;
    }


    public function getUrlKey(): ?string {
        return $this->urlMapping?->getUrlKey();
    }

    public function setUrlKey(string $urlKey): static {
        $urlMapping = $this->getUrlMapping();

        if (!$urlMapping) {
            $urlMapping = new UrlMapping();
            $urlMapping->setEntityType(get_called_class());
            $this->setUrlMapping($urlMapping);
        }

        $urlMapping->setUrlKey($this->getUrlKey());

        return $this;
    }

    #[ORM\PostPersist]
    #[ORM\PreUpdate]
    public function updateUrlMapping(): void
    {
        dd($this->getId());
       /* dd('call!');
        if (!$this->getUrlKey() || !$this->getId()) {
            return;
        }

        $urlMapping = $this->getUrlMapping();

        if (!$urlMapping) {
            $urlMapping = new UrlMapping();
            $urlMapping->setEntityId($this->getId());
            $urlMapping->setEntityType(get_called_class());
        }

        $urlMapping->setUrlKey($this->getUrlKey());

        $this->setUrlMapping($urlMapping); */
    }
}   