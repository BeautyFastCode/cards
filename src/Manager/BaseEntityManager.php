<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use App\Entity\Traits\BaseEntityInterface;
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
     * @return BaseEntityInterface
     */
    public function read(int $id): BaseEntityInterface
    {
        $baseEntity = $this->entityRepository->findOneBy(['id' => $id]);

        if ($baseEntity === null or !($baseEntity instanceof BaseEntityInterface)) {
            throw new EntityNotFoundException($this->getEntityClassName(), $id);
        }

        return $baseEntity;
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
     * @return BaseEntityInterface|null
     */
    public function create(array $data): ?BaseEntityInterface
    {
        /**@var BaseEntityInterface $baseEntity */
        $baseEntity = $this
            ->formHelper
            ->submitEntity($this->getEntityFormType(), $this->getEntity(), $data);

        if($baseEntity === null) {
            return null;
        }

        $this->entityManager->persist($baseEntity);
        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */
        return $this->read($baseEntity->getId());
    }

    /**
     * Update one an entity.
     *
     * @param int   $id
     * @param array $data
     * @param bool  $allProperties
     *
     * @return BaseEntityInterface|null
     */
    public function update(int $id, array $data, bool $allProperties = true): ?BaseEntityInterface
    {
        $baseEntity = $this->read($id);

        $this
            ->formHelper
            ->submitEntity($this->getEntityFormType(), $baseEntity, $data, $allProperties);

        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */
        return $this->read($baseEntity->getId());
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
        $baseEntity = $this->read($id);

        $this->entityManager->remove($baseEntity);
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
