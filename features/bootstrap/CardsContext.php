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
        $this->emptyEntity(Suite::class);

        /*
         * New records.
         */
        foreach ($suitesTable->getColumnsHash() as $key => $value) {

            $suite = new Suite();
            $suite->setName($value['name']);

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
}
