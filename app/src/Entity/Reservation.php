<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Reservation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Yacht::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Yacht $yacht;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private DateTimeImmutable $startTime;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private DateTimeImmutable $endTime;

    public function __construct()
    {

    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @param UuidInterface $id
     */
    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Yacht
     */
    public function getYacht(): Yacht
    {
        return $this->yacht;
    }

    /**
     * @param Yacht $yacht
     */
    public function setYacht(Yacht $yacht): void
    {
        $this->yacht = $yacht;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartTime(): DateTimeImmutable
    {
        return $this->startTime;
    }

    /**
     * @param DateTimeImmutable $startTime
     */
    public function setStartTime(DateTimeImmutable $startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndTime(): DateTimeImmutable
    {
        return $this->endTime;
    }

    /**
     * @param DateTimeImmutable $endTime
     */
    public function setEndTime(DateTimeImmutable $endTime): void
    {
        $this->endTime = $endTime;
    }
}