<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Review
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid', unique: true)]
        #[ORM\GeneratedValue(strategy: 'NONE')]
        private UuidInterface $id,

        #[ORM\ManyToOne(targetEntity: Yacht::class, cascade: ['persist'])]
        #[ORM\JoinColumn(nullable: false)]
        private Yacht $yacht,

        #[ORM\Column]
        private string $text,

        #[ORM\Column]
        private int $rating
    )
    {

    }
}