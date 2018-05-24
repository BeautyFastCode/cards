<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Deck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixture for the Deck entity.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class DeckFixtures extends Fixture
{
    /**
     * Base reference for a Deck.
     *
     * @var string
     */
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

        for ($i = 0; $i < $countDecks; ++$i) {
            $suite = new Deck();
            $suite->setName($names[$i]);

            $manager->persist($suite);

            $this->addReference(sprintf('%s%s', self::DECK_REFERENCE, $i), $suite);
        }

        $manager->flush();

        return;
    }
}
