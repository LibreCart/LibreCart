<?php 

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait UrlKeyTrait
{
    #[ORM\Column(length: 255, nullable: false, type: 'string')]
    private string $urlKey;

    public function getUrlKey(): string {
        return $this->urlKey;
    }
    public function setUrlKey(string $urlKey): void {
        $this->urlKey = $urlKey;
    }
}
