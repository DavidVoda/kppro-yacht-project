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
        $yacht1 = $manager->find(Yacht::class, YachtFixtures::YACHT_1_ID);
        $yacht2 = $manager->find(Yacht::class, YachtFixtures::YACHT_2_ID);
        $yacht3 = $manager->find(Yacht::class, YachtFixtures::YACHT_3_ID);
        $yacht4 = $manager->find(Yacht::class, YachtFixtures::YACHT_4_ID);

        $review1 = new Review();
        $review1 -> setId(Uuid::fromString('30cc4aee-22f0-4709-8672-cfa6326954c9'));
        $review1 -> setYacht($yacht1);
        $review1 -> setText('Toilet got stuck mid weeek but hey we have sea right?');
        $review1 -> setRating(8);

        $manager->persist($review1);

        $review2 = new Review();
        $review2 -> setId(Uuid::fromString('0d680abc-f959-46fe-b453-5bde4f05aeb4'));
        $review2 -> setYacht($yacht1);
        $review2 -> setText('Very good yach, had great time');
        $review2 -> setRating(10);

        $manager->persist($review2);

        $review3 = new Review();
        $review3 -> setId(Uuid::fromString('f8814328-ed88-48f9-b838-0f4de96d22b3'));
        $review3 -> setYacht($yacht2);
        $review3 -> setText('Not best one, good for the price though.');
        $review3 -> setRating(7);

        $manager->persist($review3);

        $review4 = new Review();
        $review4 -> setId(Uuid::fromString('78d34f47-1059-4432-9bfe-3c59b2911c0f'));
        $review4 -> setYacht($yacht3);
        $review4 -> setText('Amazing!');
        $review4 -> setRating(10);

        $manager->persist($review4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            YachtFixtures::class
        ];
    }
}
