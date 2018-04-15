<?php

namespace App\DataFixtures;

use App\Entity\Suite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SuiteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $countSuites = 3;

        $names = [
            'Suite A',
            'Calendar',
            'Empty Suite',
        ];

        for ($i = 0; $i < $countSuites; $i++) {
            $suite = new Suite();
            $suite->setName($names[$i]);

            $manager->persist($suite);
        }

        $manager->flush();
    }
}
