<?php

namespace App\Repository;

use App\Domain\Yacht\Exception\YachtNotFound;
use App\Entity\Yacht;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class YachtRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function get(UuidInterface $id): Yacht
    {
        return $this->entityManager->find(Yacht::class, $id) ?? throw new YachtNotFound();
    }
}
