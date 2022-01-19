<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\Yacht;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $yacht = $manager->find(Yacht::class, YachtFixtures::YACHT_1_ID);

        $manager->persist(
            new Reservation(
                Uuid::fromString('9ecdf039-ab39-4936-83fc-9c28bc6283c4'),
                $yacht,
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::RFC3339_EXTENDED,
                    '2021-01-01T12:00:00.000+00:00'
                ),
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::RFC3339_EXTENDED,
                    '2021-01-08T12:00:00.000+00:00'
                )
            )
        );

        //TODO: DANIEL add more fixtures
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            YachtFixtures::class
        ];
    }
}
