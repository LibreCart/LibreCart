<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM as ORM;

trait TimestampAbleTrait 
{
    #[ORM\Column(nullable: false)]
    private ?DateTime $createdAt;

    #[ORM\Column(nullable: true)]
    private ?DateTime $updatedAt = null;

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