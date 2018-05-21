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
use App\Exception\EntityNotFoundException;
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
class SuiteManager
{
    /**
     * @var SuiteRepository
     */
    private $suiteRepository;

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
     * @param SuiteRepository        $suiteRepository
     * @param EntityManagerInterface $entityManager
     * @param FormHelper             $formHelper
     */
    public function __construct(SuiteRepository $suiteRepository,
                                EntityManagerInterface $entityManager,
                                FormHelper $formHelper)
    {
        $this->suiteRepository = $suiteRepository;
        $this->entityManager = $entityManager;
        $this->formHelper = $formHelper;
    }

    /**
     * Read one Suite
     *
     * @param int $id
     *
     * @return Suite
     */
    public function read(int $id): Suite
    {
        $suite = $this->suiteRepository->findOneBy(['id' => $id]);

        if ($suite === null or !($suite instanceof Suite)) {
            throw new EntityNotFoundException('Suite', $id);
        }

        return $suite;
    }

    /**
     * List of all suites in the repository.
     *
     * @return array The suites
     */
    public function list(): array
    {
        return $this->suiteRepository->findAll();
    }

    /**
     * Create one Suite.
     *
     * @param array $data
     *
     * @return Suite|null
     */
    public function create(array $data): ?Suite
    {
        $suite = $this
            ->formHelper
            ->submitEntity(SuiteType::class, new Suite(), $data);

        $this->entityManager->persist($suite);
        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */
        return $this->read($suite->getId());
    }

    /**
     * Update one Suite.
     *
     * @param int   $id
     * @param array $data
     * @param bool  $allProperties
     *
     * @return Suite|null
     */
    public function update(int $id, array $data, bool $allProperties = true): ?Suite
    {
        $suite = $this->read($id);

        $this
            ->formHelper
            ->submitEntity(SuiteType::class, $suite, $data, $allProperties);

        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */
        return $this->read($suite->getId());
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

    /**
     * Get errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->formHelper->getErrors();
    }
}
