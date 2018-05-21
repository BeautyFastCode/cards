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
use App\Form\DeckType;
use App\Helper\FormHelper;
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
     * @var FormHelper
     */
    private $formHelper;

    /**
     * Class constructor
     *
     * @param DeckRepository         $deckRepository
     * @param EntityManagerInterface $entityManager
     * @param FormHelper             $formHelper
     */
    public function __construct(DeckRepository $deckRepository,
                                EntityManagerInterface $entityManager,
                                FormHelper $formHelper)
    {
        $this->deckRepository = $deckRepository;
        $this->entityManager = $entityManager;
        $this->formHelper = $formHelper;
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
     * Create one Deck.
     *
     * @param array $data
     *
     * @return Deck|null
     */
    public function create(array $data): ?Deck
    {
        $deck = $this
            ->formHelper
            ->submitEntity(DeckType::class, new Deck(), $data);

        $this->entityManager->persist($deck);
        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */

        return $this->read($deck->getId());
    }

    /**
     * Update one Deck.
     *
     * @param int   $id
     * @param array $data
     * @param bool  $allProperties
     *
     * @return Deck|null
     */
    public function update(int $id, array $data, bool $allProperties = true): ?Deck
    {
        $deck = $this->read($id);

        $this
            ->formHelper
            ->submitEntity(DeckType::class, $deck, $data, $allProperties);

        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */

        return $this->read($deck->getId());
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
