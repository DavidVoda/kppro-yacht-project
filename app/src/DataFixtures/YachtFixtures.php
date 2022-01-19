<?php

namespace App\DataFixtures;

use App\Entity\Yacht;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class YachtFixtures extends Fixture
{
    public const YACHT_1_ID = '3531c492-0c44-4390-845f-45235f25cd92';

    public function load(ObjectManager $manager): void
    {
        $manager->persist(
            new Yacht(
                Uuid::fromString(self::YACHT_1_ID),
                'St. Johnson',
                'Kepork 2000',
                8,
                999
            )
        );

        //TODO: DANIEL add more fixtures

        $manager->flush();
    }
}
