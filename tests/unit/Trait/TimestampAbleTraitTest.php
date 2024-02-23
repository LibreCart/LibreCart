<?php 
namespace App\Tests\Unit\Trait;

use PHPUnit\Framework\TestCase;
use App\Entity\Traits\TimestampAbleTrait;
use DateTime;

class TimestampAbleTraitTest extends TestCase {
    public function testEntityHasUpdatedTimestamps(): void 
    {
        $entity = new class {
            use TimestampAbleTrait;
        };
        
        $this->assertNull($entity->getUpdatedAt());

        $entity->updatedTimestamps();

        $this->assertInstanceOf(DateTime::class, $entity->getCreatedAt());
        $this->assertInstanceOf(DateTime::class, $entity->getUpdatedAt());
    }
}