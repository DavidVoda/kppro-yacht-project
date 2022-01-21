<?php

namespace App\DataFixtures;

use App\Entity\Review;
use App\Entity\Yacht;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ReviewFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $yacht = $manager->find(Yacht::class, YachtFixtures::YACHT_1_ID);
        $yacht2 = $manager->find(Yacht::class, YachtFixtures::YACHT_2_ID);
        $yacht3 = $manager->find(Yacht::class, YachtFixtures::YACHT_3_ID);

        /*
        $manager->persist(
            new Review(
                Uuid::fromString('30cc4aee-22f0-4709-8672-cfa6326954c9'),
                $yacht,
                'Very good yach, had great time',
                9
            )
        );

        $manager->persist(
            new Review(
                Uuid::fromString('0d680abc-f959-46fe-b453-5bde4f05aeb4'),
                $yacht,
                'Toilet got stuck mid weeek but hey we have sea right?',
                8
            )
        );

        $manager->persist(
            new Review(
                Uuid::fromString('f8814328-ed88-48f9-b838-0f4de96d22b3'),
                $yacht2,
                'Not best one, good for the price though.',
                7
            )
        );

        $manager->persist(
            new Review(
                Uuid::fromString('78d34f47-1059-4432-9bfe-3c59b2911c0f'),
                $yacht2,
                'Very good yach, had great time',
                9
            )
        );

        $manager->persist(
            new Review(
                Uuid::fromString('83303c61-8941-40fd-b2d2-a08d982e8fe9'),
                $yacht3,
                'Very good yach, had great time',
                9
            )
        );

        */
        //TODO: DANIEL add more fixtures
        $manager->flush();
    }
}
