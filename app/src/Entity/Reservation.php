<?php

namespace App\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
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

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

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
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = Uuid::fromString($id);
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStartTime(): DateTimeImmutable
    {
        return $this->startTime;
    }

    /**
     * @param DateTimeInterface $startTime
     */
    public function setStartTime(DateTimeInterface $startTime): void
    {
        $this->startTime = DateTimeImmutable::createFromInterface($startTime);
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEndTime(): DateTimeImmutable
    {
        return $this->endTime;
    }

    /**
     * @param DateTimeInterface $endTime
     */
    public function setEndTime(DateTimeInterface $endTime): void
    {
        $this->endTime = DateTimeImmutable::createFromInterface($endTime);
    }

    public function getDays(): int
    {
        return $this->endTime->diff($this->startTime)->days;
    }

    public function getTotalPrice(): int
    {
        return $this->getDays() * $this->getYacht()->getPricePerDay();
    }
}
