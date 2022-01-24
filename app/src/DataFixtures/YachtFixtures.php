<?php

namespace App\DataFixtures;

use App\Domain\Yacht\YachtImageAssigner;
use App\Entity\Yacht;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;

class YachtFixtures extends Fixture
{
    public const YACHT_1_ID = '3531c492-0c44-4390-845f-45235f25cd92';
    public const YACHT_2_ID = 'b39b86a3-8a3b-44c1-999f-1708afac721d';
    public const YACHT_3_ID = '35d33d98-49ea-4cd2-ac16-654711ab933a';
    public const YACHT_4_ID = 'd51a6eda-8591-4d7f-9115-69871fcb6061';

    public function __construct(private YachtImageAssigner $assigner)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $yacht1 = new Yacht();
        $yacht1 -> setId(self::YACHT_1_ID);
        $yacht1 -> setName('St. Johnson');
        $yacht1 -> setModel('Kepork 2000');
        $yacht1 -> setPassengerCount(8);
        $yacht1 -> setPricePerDay(999);

        $this->assignImage($yacht1, new File(__DIR__ . '/YachtFixtures/st-johnson-2020-04-23.jpg'));
        $this->assignImage($yacht1, new File(__DIR__ . '/YachtFixtures/st-johnson-2020-04-35.jpg'));

        $manager->persist($yacht1);

        $yacht2 = new Yacht();
        $yacht2 -> setId(self::YACHT_2_ID);
        $yacht2 -> setName('HMS Fildos');
        $yacht2 -> setModel('Kepork 2012');
        $yacht2 -> setPassengerCount(8);
        $yacht2 -> setPricePerDay(1500);

        $this->assignImage($yacht2, new File(__DIR__ . '/YachtFixtures/kepork-2012.jpg'));

        $manager->persist($yacht2);

        $yacht3 = new Yacht();
        $yacht3 -> setId(self::YACHT_3_ID);
        $yacht3 -> setName('Mr. Anderson');
        $yacht3 -> setModel('Matrix 1999');
        $yacht3 -> setPassengerCount(9);
        $yacht3 -> setPricePerDay(1350);

        $this->assignImage($yacht3, new File(__DIR__ . '/YachtFixtures/matrix-1.jpg'));
        $this->assignImage($yacht3, new File(__DIR__ . '/YachtFixtures/matrix-2.jpg'));

        $manager->persist($yacht3);

        $yacht4 = new Yacht();
        $yacht4 -> setId(self::YACHT_4_ID);
        $yacht4 -> setName('IMN Carpenter');
        $yacht4 -> setModel('Kidos 4C');
        $yacht4 -> setPassengerCount(12);
        $yacht4 -> setPricePerDay(2010);

        $this->assignImage($yacht4, new File(__DIR__ . '/YachtFixtures/kidos-4c.jpg'));
        $this->assignImage($yacht4, new File(__DIR__ . '/YachtFixtures/kidos-4cc.jpg'));
        $this->assignImage($yacht4, new File(__DIR__ . '/YachtFixtures/kidos-4ccc.jpg'));

        $manager->persist($yacht4);

        $manager->flush();
    }

    public function assignImage(Yacht $yacht, File $image)
    {
        $copy = "{$image->getPath()}/fixture-{$image->getBasename()}";
        copy($image->getRealPath(), $copy);

        $this->assigner->assign($yacht, new File($copy));
    }
}
