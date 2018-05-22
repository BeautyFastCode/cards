<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use App\Entity\Traits\BaseInterface;
use App\Exception\EntityNotFoundException;
use App\Helper\FormHelper;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * BaseEntityManager
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
abstract class BaseEntityManager implements BaseEntityManagerInterface
{
    /**
     * @var ObjectRepository
     */
    private $entityRepository;

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
     * @param ObjectRepository       $entityRepository
     * @param EntityManagerInterface $entityManager
     * @param FormHelper             $formHelper
     */
    public function __construct(ObjectRepository $entityRepository,
                                EntityManagerInterface $entityManager,
                                FormHelper $formHelper)
    {
        $this->entityRepository = $entityRepository;
        $this->entityManager = $entityManager;
        $this->formHelper = $formHelper;
    }

    abstract protected function getEntity();
    abstract protected function getEntityClassName(): string;
    abstract protected function getEntityFormType();

    /**
     * Read one an entity
     *
     * @param int $id
     *
     * @return BaseInterface
     */
    public function read(int $id): BaseInterface
    {
        $entity = $this->entityRepository->findOneBy(['id' => $id]);

        if ($entity === null or !($entity instanceof BaseInterface)) {
            throw new EntityNotFoundException($this->getEntityClassName(), $id);
        }

        return $entity;
    }

    /**
     * List of all an entities in the repository.
     *
     * @return array An entities
     */
    public function list(): array
    {
        return $this->entityRepository->findAll();
    }

    /**
     * Create one an entity.
     *
     * @param array $data
     *
     * @return BaseInterface|null
     */
    public function create(array $data): ?BaseInterface
    {
        /**@var BaseInterface $entity */
        $entity = $this
            ->formHelper
            ->submitEntity($this->getEntityFormType(), $this->getEntity(), $data);

        if($entity === null) {
            return null;
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */
        return $this->read($entity->getId());
    }

    /**
     * Update one an entity.
     *
     * @param int   $id
     * @param array $data
     * @param bool  $allProperties
     *
     * @return BaseInterface|null
     */
    public function update(int $id, array $data, bool $allProperties = true): ?BaseInterface
    {
        $suite = $this->read($id);

        $this
            ->formHelper
            ->submitEntity($this->getEntityFormType(), $suite, $data, $allProperties);

        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */
        return $this->read($suite->getId());
    }

    /**
     * Delete one an entity.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id):void
    {
        $entity = $this->read($id);

        $this->entityManager->remove($entity);
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
