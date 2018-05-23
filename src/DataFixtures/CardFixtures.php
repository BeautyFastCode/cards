<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Card;
use App\Entity\Deck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixture for the Card entity.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class CardFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $countCards = 3;

        $questions = [
            'Front Card',
            'How are you?',
            'What colour do you like?',
        ];

        $answers = [
            'Back Card',
            'I\'m fine.',
            'I like the red cherry.',
        ];

        for ($i = 0; $i < $countCards; $i++) {
            $card = new Card();
            $card->setQuestion($questions[$i]);
            $card->setAnswer($answers[$i]);

            /** @var Deck $deck */
            $deck = $this->getReference(sprintf('%s%s', DeckFixtures::DECK_REFERENCE, 0));
            $card->setDeck($deck);

            $manager->persist($card);
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
