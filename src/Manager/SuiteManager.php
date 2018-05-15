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
use App\Repository\SuiteRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

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
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;

    /**
     * @var array
     */
    private $formErrors;

    /**
     * Class constructor
     *
     * @param SuiteRepository        $suiteRepository
     * @param EntityManagerInterface $entityManager
     * @param FormFactoryInterface   $formFactory
     * @param FormErrorSerializer    $formErrorSerializer
     */
    public function __construct(SuiteRepository $suiteRepository,
                                EntityManagerInterface $entityManager,
                                FormFactoryInterface $formFactory,
                                FormErrorSerializer $formErrorSerializer)
    {
        $this->suiteRepository = $suiteRepository;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->formErrorSerializer = $formErrorSerializer;

        $this->formErrors = [];
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
        $form = $this->formFactory->create(SuiteType::class, new Suite());
        $form->submit($data);

        if (false === $form->isValid()) {
            $this->formErrors = $this
                ->formErrorSerializer
                ->convertFormToArray($form);

            return null;
        }

        $suite = $form->getData();

        $this->entityManager->persist($suite);
        $this->entityManager->flush();

        return $suite;
    }

    /**
     * Delete one Suite.
     *
     * @param Suite $suite
     *
     * @return void
     */
    public function delete(Suite $suite):void
    {
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
        return $this->formErrors;
    }
}
