<?php

use App\Entity\Card;
use App\Entity\Deck;
use App\Entity\Suite;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class CardsContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Class constructor
     *
     * @param KernelInterface        $kernel
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(KernelInterface $kernel, EntityManagerInterface $entityManager)
    {
        $this->kernel = $kernel;
        $this->entityManager = $entityManager;
    }

    /**
     * @Given there are Suites with the following details:
     * @param TableNode $suitesTable
     */
    public function thereAreSuitesWithTheFollowingDetails(TableNode $suitesTable)
    {
        $this->emptySuite();

        /*
         * New records.
         */
        foreach ($suitesTable->getColumnsHash() as $key => $value) {

            $suite = new Suite();
            $suite->setName($value['name']);

            if (array_key_exists('decks', $value)) {

                /*
                 * Find and add a Deck if it exists.
                 */
                $deckNames = explode(',', $value['decks']);

                foreach ($deckNames as $deckName) {

                    $deckName = trim($deckName);

                    if (!empty($deckName)) {

                        $deck = $this->entityManager
                            ->getRepository(Deck::class)
                            ->findOneBy([
                                'name' => $deckName,
                            ]);

                        if ($deck) {
                            $suite->addDeck($deck);
                        }
                    }
                }
            }

            $this->entityManager->persist($suite);
        }

        $this->entityManager->flush();
    }

    /**
     * @Given /^there are Decks with the following details:$/
     * @param TableNode $decksTable
     */
    public function thereAreDecksWithTheFollowingDetails(TableNode $decksTable)
    {
        $this->emptyEntity(Deck::class);

        /*
         * New records.
         */
        foreach ($decksTable->getColumnsHash() as $key => $value) {

            $deck = new Deck();
            $deck->setName($value['name']);

            $this->entityManager->persist($deck);
        }

        $this->entityManager->flush();

    }

    /**
     * @Given /^there are Cards with the following details:$/
     * @param TableNode $cardTable
     */
    public function thereAreCardsWithTheFollowingDetails(TableNode $cardTable)
    {
        $this->emptyEntity(Card::class);

        /*
         * New records.
         */
        foreach ($cardTable->getColumnsHash() as $key => $value) {

            $card = new Card();
            $card->setQuestion($value['question']);
            $card->setAnswer($value['answer']);

            $this->entityManager->persist($card);
        }

        $this->entityManager->flush();
    }

    /**
     * @param string $entityClassName The class/type whose instances are subject to the deletion.
     */
    private function emptyEntity($entityClassName)
    {
        /*
         * Delete all previous records.
         */
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->delete($entityClassName)
            ->getQuery();

        $query->execute();
    }

    /**
     * Remove all Suites without deleting Decks.
     */
    private function emptySuite()
    {
        $suites = $this->entityManager
            ->getRepository(Suite::class)
            ->findAll();

        /** @var Suite $suite */
        foreach ($suites as $suite) {

            /*
             * Delete only relationship to Deck (join table), not Deck.
             */
            foreach ($suite->getDecks() as $deck) {
                $suite->removeDeck($deck);
            }
            $this->entityManager->flush();

            /*
             * Delete Suite.
             */
            $this->entityManager->remove($suite);
            $this->entityManager->flush();
        }
    }
}
