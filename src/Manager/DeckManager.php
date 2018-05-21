<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;
use App\Entity\Deck;
use App\Exception\EntityNotFoundException;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * DeckManager
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class DeckManager
{
    /**
     * @var DeckRepository
     */
    private $deckRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Class constructor
     *
     * @param DeckRepository         $deckRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(DeckRepository $deckRepository,
                                EntityManagerInterface $entityManager)
    {
        $this->deckRepository = $deckRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Read one Deck
     *
     * @param int $id
     *
     * @return Deck
     */
    public function read(int $id): Deck
    {
        $deck = $this->deckRepository->findOneBy(['id' => $id]);

        if ($deck === null or !($deck instanceof Deck)) {
            throw new EntityNotFoundException('Deck', $id);
        }

        return $deck;
    }

    /**
     * List of all decks in the repository.
     *
     * @return array The decks
     */
    public function list(): array
    {
        return $this->deckRepository->findAll();
    }

    /**
     * Delete one Deck.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id):void
    {
        $deck = $this->read($id);

        /*
        * Delete only relationship to Suite (join table), not Suite.
        */
        foreach ($deck->getSuites() as $suite) {
            $deck->removeSuite($suite);
        }
        $this->entityManager->flush();

        /*
         * Delete Deck.
         */
        $this->entityManager->remove($deck);
        $this->entityManager->flush();

        return;
    }
}
