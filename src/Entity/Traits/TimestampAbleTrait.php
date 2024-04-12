<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait TimestampAbleTrait 
{
    #[ORM\Column(nullable: false)]
    private ?DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $updatedAt = null;

    public function __construct() {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAt(): ?DateTime {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void {
        $this->updatedAt = $updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updatedTimestamps(): void {
        if (!$this->createdAt) {
            $this->createdAt = new DateTime();
        }
        
        $this->updatedAt = new DateTime();
    }
}