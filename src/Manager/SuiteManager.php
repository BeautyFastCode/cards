<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use App\Entity\Suite;
use App\Form\SuiteType;
use App\Helper\FormHelper;
use App\Repository\SuiteRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * SuiteManager
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class SuiteManager extends BaseEntityManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Class constructor
     *
     * @param SuiteRepository        $suiteRepository
     * @param EntityManagerInterface $entityManager
     * @param FormHelper             $formHelper
     */
    public function __construct(SuiteRepository $suiteRepository,
                                EntityManagerInterface $entityManager,
                                FormHelper $formHelper)
    {
        $this->entityManager = $entityManager;

        parent::__construct($suiteRepository, $entityManager, $formHelper);
    }

    protected function getEntity()
    {
        return new Suite();
    }

    protected function getEntityClassName(): string
    {
        return Suite::class;
    }

    protected function getEntityFormType()
    {
        return SuiteType::class;
    }

    /**
     * Delete one Suite.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id):void
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
