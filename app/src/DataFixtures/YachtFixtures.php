<?php

namespace App\DataFixtures;

use App\Entity\Yacht;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class YachtFixtures extends Fixture
{
    public const YACHT_1_ID = '3531c492-0c44-4390-845f-45235f25cd92';
    public const YACHT_2_ID = 'b39b86a3-8a3b-44c1-999f-1708afac721d';
    public const YACHT_3_ID = '35d33d98-49ea-4cd2-ac16-654711ab933a';
    public const YACHT_4_ID = 'd51a6eda-8591-4d7f-9115-69871fcb6061';

    public function load(ObjectManager $manager): void
    {
        $yacht = new Yacht();
        $yacht -> setId(self::YACHT_1_ID);
        $yacht -> setName('St. Johnson');
        $yacht -> setModel('Kepork 2000');
        $yacht -> setPassengerCount(8);
        $yacht -> setPricePerDay(999);

        $manager->persist($yacht);

        $yacht2 = new Yacht();
        $yacht2 -> setId(self::YACHT_2_ID);
        $yacht2 -> setName('HMS Fildos');
        $yacht2 -> setModel('Kepork 2012');
        $yacht2 -> setPassengerCount(8);
        $yacht2 -> setPricePerDay(1500);

        $manager->persist($yacht2);

        $yacht3 = new Yacht();
        $yacht3 -> setId(self::YACHT_3_ID);
        $yacht3 -> setName('Mr. Anderson');
        $yacht3 -> setModel('Matrix 1999');
        $yacht3 -> setPassengerCount(9);
        $yacht3 -> setPricePerDay(1350);

        $manager->persist($yacht3);

        $yacht4 = new Yacht();
        $yacht4 -> setId(self::YACHT_4_ID);
        $yacht4 -> setName('IMN Carpenter');
        $yacht4 -> setModel('Kidos 4C');
        $yacht4 -> setPassengerCount(12);
        $yacht4 -> setPricePerDay(2010);

        $manager->persist($yacht4);

        //TODO: DANIEL add more fixtures

        $manager->flush();
    }
}
