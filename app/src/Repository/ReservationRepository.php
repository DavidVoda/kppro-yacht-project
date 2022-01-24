<?php

namespace App\Repository;

use App\Domain\Reservation\Exception\ReservationNotFound;
use App\Entity\Reservation;
use App\Entity\Yacht;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class ReservationRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function get(UuidInterface $id): Reservation
    {
        return $this->entityManager->find(Reservation::class, $id) ?? throw new ReservationNotFound();
    }

    /**
     * @return array<Reservation>
     */
    public function getByYacht(UuidInterface $yachtId): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('r')
            ->from(Reservation::class, 'r')
            ->where('r.yacht = :yachtId')
            ->setParameters([
                                'yachtId' => $this->entityManager->getReference(Yacht::class, $yachtId)
                            ])
            ->getQuery()
            ->getResult();
    }
}
