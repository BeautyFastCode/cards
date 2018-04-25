<?php

namespace App\DataFixtures;

use App\Entity\Card;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CardFixtures extends Fixture
{
    public const CARD_REFERENCE = 'card_';

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

            $manager->persist($card);

            $this->addReference(sprintf('%s%s', self::CARD_REFERENCE, $i), $card);
        }

        $manager->flush();

        return;
    }
}
