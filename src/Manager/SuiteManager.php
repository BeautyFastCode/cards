<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use App\Entity\BaseEntity;
use App\Entity\Suite;
use App\Form\SuiteType;
use App\Helper\FormHelper;
use App\Repository\SuiteRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Manager - base CRUD functionality for the suite entity.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class SuiteManager extends BaseEntityManager
{
    /**
     * Interface to an entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * {@inheritdoc}
     */
    public function __construct(SuiteRepository $suiteRepository,
                                EntityManagerInterface $entityManager,
                                FormHelper $formHelper)
    {
        $this->entityManager = $entityManager;

        parent::__construct($suiteRepository, $entityManager, $formHelper);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntity(): BaseEntity
    {
        return new Suite();
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClassName(): string
    {
        return Suite::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityFormTypeClassName(): string
    {
        return SuiteType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): void
    {
        /** @var Suite $suite */
        $suite = $this->read($id);

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

        return;
    }
}
