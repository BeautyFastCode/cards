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
class DeckManager extends BaseEntityManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

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
        $this->entityManager = $entityManager;

        parent::__construct($deckRepository, $entityManager, $formHelper);
    }

    protected function getEntity()
    {
        return new Deck();
    }

    protected function getEntityClassName(): string
    {
        return Deck::class;
    }

    protected function getEntityFormType()
    {
        return DeckType::class;
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
        /** @var Deck $deck */
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
