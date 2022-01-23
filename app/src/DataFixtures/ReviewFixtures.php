<?php

namespace App\DataFixtures;

use App\Entity\Review;
use App\Entity\Yacht;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use DateTimeImmutable;
use DateTimeInterface;

class ReviewFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $yacht1 = $manager->find(Yacht::class, YachtFixtures::YACHT_1_ID);
        $yacht2 = $manager->find(Yacht::class, YachtFixtures::YACHT_2_ID);
        $yacht3 = $manager->find(Yacht::class, YachtFixtures::YACHT_3_ID);
        $yacht4 = $manager->find(Yacht::class, YachtFixtures::YACHT_4_ID);

        $user1 = $manager->find(User::class, UserFixtures::USER_1_ID);
        $user2 = $manager->find(User::class, UserFixtures::USER_2_ID);

        $review1 = new Review();
        $review1 -> setId(Uuid::fromString('30cc4aee-22f0-4709-8672-cfa6326954c9'));
        $review1 -> setYacht($yacht1);
        $review1 -> setUser($user2);
        $review1 -> setText('Toilet got stuck mid weeek but hey we have sea right?');
        $review1 -> setRating(8);
        $review1 -> setCreateDate(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));

        $manager->persist($review1);

        $review2 = new Review();
        $review2 -> setId(Uuid::fromString('0d680abc-f959-46fe-b453-5bde4f05aeb4'));
        $review2 -> setYacht($yacht1);
        $review2 -> setUser($user2);
        $review2 -> setText('Very good yach, had great time');
        $review2 -> setRating(10);
        $review2 -> setCreateDate(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));

        $manager->persist($review2);

        $review3 = new Review();
        $review3 -> setId(Uuid::fromString('f8814328-ed88-48f9-b838-0f4de96d22b3'));
        $review3 -> setYacht($yacht2);
        $review3 -> setUser($user2);
        $review3 -> setText('Not best one, good for the price though.');
        $review3 -> setRating(7);
        $review3 -> setCreateDate(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));

        $manager->persist($review3);

        $review4 = new Review();
        $review4 -> setId(Uuid::fromString('78d34f47-1059-4432-9bfe-3c59b2911c0f'));
        $review4 -> setYacht($yacht3);
        $review4 -> setUser($user2);
        $review4 -> setText('Amazing!');
        $review4 -> setRating(10);
        $review4 -> setCreateDate(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));

        $manager->persist($review4);

        $review5 = new Review();
        $review5 -> setId(Uuid::fromString('30cc4aee-22f0-4709-8672-cfa6326954c2'));
        $review5 -> setYacht($yacht1);
        $review5 -> setUser($user2);
        $review5 -> setText('Toilet got stuck mid weeek but hey we have sea right?');
        $review5 -> setRating(5);
        $review5 -> setCreateDate(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));

        $manager->persist($review1);

        $review6 = new Review();
        $review6 -> setId(Uuid::fromString('30cc4aee-22f0-4709-8672-cfa6326954c5'));
        $review6 -> setYacht($yacht1);
        $review6 -> setUser($user2);
        $review6 -> setText('Toilet got stuck mid weeek but hey we have sea right?');
        $review6 -> setRating(8);
        $review6 -> setCreateDate(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));

        $manager->persist($review6);

        $review7 = new Review();
        $review7 -> setId(Uuid::fromString('30cc4aee-22f0-4709-8672-cfa6326954c6'));
        $review7 -> setYacht($yacht1);
        $review7 -> setUser($user2);
        $review7 -> setText('Toilet got stuck mid weeek but hey we have sea right?');
        $review7 -> setRating(8);
        $review7 -> setCreateDate(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));

        $manager->persist($review7);

        $review8 = new Review();
        $review8 -> setId(Uuid::fromString('30cc4aee-22f0-4709-8672-cfa6326954c7'));
        $review8 -> setYacht($yacht1);
        $review8 -> setUser($user2);
        $review8 -> setText('Toilet got stuck mid weeek but hey we have sea right?');
        $review8 -> setRating(8);
        $review8 -> setCreateDate(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));

        $manager->persist($review8);

        $review9 = new Review();
        $review9 -> setId(Uuid::fromString('30cc4aee-22f0-4709-8672-cfa6326954c8'));
        $review9 -> setYacht($yacht1);
        $review9 -> setUser($user2);
        $review9 -> setText('Toilet got stuck mid weeek but hey we have sea right?');
        $review9 -> setRating(8);
        $review9 -> setCreateDate(DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            '2021-02-01T12:00:00.000+00:00'
        ));

        $manager->persist($review9);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            YachtFixtures::class,
            UserFixtures::class
        ];
    }
}
