<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Config;

class ConfigFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        /** DATE 1 : START */
        $startDate1 = new Config();
        $startDate1->setCkey('start_date1');
        $startDate1->setCvalue('2019-05-01');
        $startDate1->setName('Date de début (première période)');
        $manager->persist($startDate1);

        /** DATE 1 : END */
        $endDate1 = new Config();
        $endDate1->setCkey('end_date1');
        $endDate1->setCvalue('2019-06-01');
        $endDate1->setName('Date de fin (première période)');
        $manager->persist($endDate1);

        /** DATE 2 : START */
        $startDate2 = new Config();
        $startDate2->setCkey('start_date2');
        $startDate2->setCvalue('2020-05-01');
        $startDate2->setName('Date de début (seconde période)');
        $manager->persist($startDate2);

        /** DATE 2 : END */
        $endDate2 = new Config();
        $endDate2->setCkey('end_date2');
        $endDate2->setCvalue('2020-06-01');
        $endDate2->setName('Date de fin (seconde période)');
        $manager->persist($endDate2);

        $manager->flush();
    }
}