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
        $yacht2 = $manager->find(Yacht::class, YachtFixtures::YACHT_2_ID);
        $yacht3 = $manager->find(Yacht::class, YachtFixtures::YACHT_3_ID);

        /*
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
        $manager->persist(
            new Reservation(
                Uuid::fromString('d9c680d1-e28c-4585-a28f-296cc2fdf351'),
                $yacht2,
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
        $manager->persist(
            new Reservation(
                Uuid::fromString('22f1202b-5ce1-4647-abbb-8b2b86ce66c1'),
                $yacht2,
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::RFC3339_EXTENDED,
                    '2021-01-08T12:00:00.000+00:00'
                ),
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::RFC3339_EXTENDED,
                    '2021-01-20T12:00:00.000+00:00'
                )
            )
        );
        $manager->persist(
            new Reservation(
                Uuid::fromString('8a4497d9-39d3-4b75-aaaf-03910a58bdae'),
                $yacht3,
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::RFC3339_EXTENDED,
                    '2021-02-01T12:00:00.000+00:00'
                ),
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::RFC3339_EXTENDED,
                    '2021-02-24T12:00:00.000+00:00'
                )
            )
        );

        */

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
