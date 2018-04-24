<?php

namespace App\DataFixtures;

use App\Entity\Deck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DeckFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $countDecks = 5;

        $names = [
            'Welcome Deck',
            'Untitled Deck',
            'Information Deck',
            '2018 - 04',
            'Project Cards',
        ];

        for ($i = 0; $i < $countDecks; $i++) {
            $suite = new Deck();
            $suite->setName($names[$i]);

            $manager->persist($suite);
        }

        $manager->flush();
    }
}
