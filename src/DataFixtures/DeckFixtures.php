<?php

namespace App\DataFixtures;

use App\Entity\Deck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DeckFixtures extends Fixture implements DependentFixtureInterface
{
    public const DECK_REFERENCE = 'deck_';

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
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

            $this->addReference(sprintf('%s%s', self::DECK_REFERENCE, $i), $suite);
        }

        $manager->flush();

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies(): array
    {
        return [
            CardFixtures::class,
        ];
    }
}
