<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Yacht
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid', unique: true)]
        #[ORM\GeneratedValue(strategy: 'NONE')]
        private UuidInterface $id,

        #[ORM\Column]
        private string $name,

        #[ORM\Column]
        private string $model,

        #[ORM\Column]
        private int $passengerCount,

        #[ORM\Column]
        private string $pricePerDay
    )
    {
    }
}
