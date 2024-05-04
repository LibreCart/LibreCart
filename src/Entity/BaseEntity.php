<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\UuidTrait;
use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\TimestampAbleTrait;

#[ORM\MappedSuperclass]
#[ApiResource()]
class BaseEntity 
{
    use UuidTrait;
    use TimestampAbleTrait;
}