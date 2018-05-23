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
        $this->emptySuites();

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
        $this->emptyDecks();

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
        /*
         * New records.
         */
        foreach ($cardTable->getColumnsHash() as $key => $value) {

            $card = new Card();
            $card->setQuestion($value['question']);
            $card->setAnswer($value['answer']);

            if(array_key_exists('deck', $value)) {

                $deck = $this->entityManager
                    ->getRepository(Deck::class)
                    ->findOneBy([
                        'name' => sprintf('%s', $value['deck']),
                    ]);

                if ($deck) {
                    $card->setDeck($deck);
                }

            }

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
    private function emptySuites()
    {
        /*
         * This will disable the SoftDeleteable filter,
         * so entities which were "soft-deleted" will appear in results
         */
        $this->entityManager->getFilters()->disable('softdeleteable');

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
             * Hard delete the Suite.
             */
            $suite->setDeletedAt(new DateTime());
            $this->entityManager->remove($suite);
            $this->entityManager->flush();
        }

        $this->entityManager->getFilters()->enable('softdeleteable');
    }

    /**
     * Remove all Deck with assigned Cards.
     */
    private function emptyDecks()
    {
        /*
         * This will disable the SoftDeleteable filter,
         * so entities which were "soft-deleted" will appear in results
         */
        $this->entityManager->getFilters()->disable('softdeleteable');


        $decks = $this->entityManager
            ->getRepository(Deck::class)
            ->findAll();

        /** @var Deck $deck */
        foreach ($decks as $deck) {

            /*
             * Hard delete the Deck and assigned Cards.
             */

            /** @var Card $card */
            foreach ($deck->getCards() as $card) {
                $card->setDeletedAt(new DateTime());
            }

            $deck->setDeletedAt(new DateTime());
            $this->entityManager->remove($deck);
        }
        $this->entityManager->flush();

        $this->entityManager->getFilters()->enable('softdeleteable');
    }
}
