<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1 -> setEmail('admin@gmail.com');
        $password = $this->hasher->hashPassword($user1, 'Heslo123');
        $user1->setPassword($password);
        $user1 -> setRoles(['ROLE_ADMIN']);

        $manager->persist($user1);

        $user2 = new User();
        $user2 -> setEmail('user@gmail.com');
        $password = $this->hasher->hashPassword($user2, 'Heslo123');
        $user2->setPassword($password);
        //$user2 -> setRoles(['ADMIN']);

        $manager->persist($user2);

        $manager->flush();
    }
}
