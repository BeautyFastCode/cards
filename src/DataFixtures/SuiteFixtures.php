<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Deck;
use App\Entity\Suite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixture for the Suite entity.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class SuiteFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $countSuites = 3;

        $suites = [
            [
                'name'  => 'Suite A',
                'decks' => [
                    1,
                    0,
                    2,
                ],
            ],
            [
                'name'  => 'Calendar',
                'decks' => [
                    3,
                    4,
                ],
            ],
            [
                'name' => 'Empty Suite',
            ],
        ];

        for ($i = 0; $i < $countSuites; $i++) {

            $suite = new Suite();
            $suite->setName($suites[$i]['name']);

            if (array_key_exists('decks', $suites[$i])) {
                foreach ($suites[$i]['decks'] as $deckId) {

                    /** @var Deck $deck */
                    $deck = $this->getReference(sprintf('%s%s', DeckFixtures::DECK_REFERENCE, $deckId));
                    $suite->addDeck($deck);
                }
            }

            $manager->persist($suite);
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
            DeckFixtures::class,
        ];
    }
}
