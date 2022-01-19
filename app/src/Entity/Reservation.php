<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Reservation
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'uuid', unique: true)]
        #[ORM\GeneratedValue(strategy: 'NONE')]
        private UuidInterface $id,

        #[ORM\ManyToOne(targetEntity: Yacht::class, cascade: ['persist'])]
        #[ORM\JoinColumn(nullable: false)]
        private Yacht $yacht,

        #[ORM\Column(type: 'datetimetz_immutable')]
        private DateTimeImmutable $startTime,

        #[ORM\Column(type: 'datetimetz_immutable')]
        private DateTimeImmutable $endTime,
    )
    {
    }
}