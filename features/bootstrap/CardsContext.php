<?php

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
        /*
         * Delete all previous records.
         */
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->delete('App:Suite', 's')
            ->getQuery();

        $query->execute();

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
}
