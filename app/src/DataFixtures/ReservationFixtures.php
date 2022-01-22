<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use App\Entity\Review;
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
        $yacht1 = $manager->find(Yacht::class, YachtFixtures::YACHT_1_ID);
        $yacht2 = $manager->find(Yacht::class, YachtFixtures::YACHT_2_ID);
        $yacht3 = $manager->find(Yacht::class, YachtFixtures::YACHT_3_ID);
        $yacht4 = $manager->find(Yacht::class, YachtFixtures::YACHT_4_ID);

        $reservation1 = new Reservation();
        $reservation1 -> setId(Uuid::fromString('9ecdf039-ab39-4936-83fc-9c28bc6283c4'));
        $reservation1 -> setYacht($yacht1);
        $reservation1 -> setStartTime(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-01-01T12:00:00.000+00:00'
        ));
        $reservation1 -> setEndTime(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-01-08T12:00:00.000+00:00'
        ));

        $manager->persist($reservation1);

        $reservation2 = new Reservation();
        $reservation2 -> setId(Uuid::fromString('d9c680d1-e28c-4585-a28f-296cc2fdf351'));
        $reservation2 -> setYacht($yacht1);
        $reservation2 -> setStartTime(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-01-01T12:00:00.000+00:00'
        ));
        $reservation2 -> setEndTime(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-01-08T12:00:00.000+00:00'
        ));

        $manager->persist($reservation2);

        $reservation3 = new Reservation();
        $reservation3 -> setId(Uuid::fromString('22f1202b-5ce1-4647-abbb-8b2b86ce66c1'));
        $reservation3 -> setYacht($yacht1);
        $reservation3 -> setStartTime(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-01-08T12:00:00.000+00:00'
        ));
        $reservation3 -> setEndTime(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-01-20T12:00:00.000+00:00'
        ));

        $manager->persist($reservation3);

        $reservation4 = new Reservation();
        $reservation4 -> setId(Uuid::fromString('8a4497d9-39d3-4b75-aaaf-03910a58bdae'));
        $reservation4 -> setYacht($yacht1);
        $reservation4 -> setStartTime(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));
        $reservation4 -> setEndTime(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-24T12:00:00.000+00:00'
        ));

        $manager->persist($reservation4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            YachtFixtures::class
        ];
    }
}
