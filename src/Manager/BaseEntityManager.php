<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use App\Entity\BaseEntity;
use App\Entity\Traits\BaseEntityInterface;
use App\Exception\EntityNotFoundException;
use App\Helper\FormHelper;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Manager - base CRUD functionality for an entities.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
abstract class BaseEntityManager implements BaseEntityManagerInterface
{
    /**
     * Repository for an entity.
     *
     * @var ObjectRepository
     */
    private $entityRepository;

    /**
     * Interface to an entity manager.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Helper for create or update and validate an entity.
     *
     * @var FormHelper
     */
    private $formHelper;

    /**
     * Class constructor
     *
     * @param ObjectRepository       $entityRepository Repository for an entity.
     * @param EntityManagerInterface $entityManager    Interface to an entity manager.
     * @param FormHelper             $formHelper       Helper for create or update and validate an entity.
     */
    public function __construct(ObjectRepository $entityRepository,
                                EntityManagerInterface $entityManager,
                                FormHelper $formHelper)
    {
        $this->entityRepository = $entityRepository;
        $this->entityManager = $entityManager;
        $this->formHelper = $formHelper;
    }

    /**
     * Returns object that represents an entity.
     *
     * @return BaseEntity The entity
     */
    abstract protected function getEntity(): BaseEntity;

    /**
     * Returns an entity class name.
     *
     * @return string
     */
    abstract protected function getEntityClassName(): string;

    /**
     * Returns the form type class name for an entity.
     *
     * @return string
     */
    abstract protected function getEntityFormTypeClassName();

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function list(): array
    {
        return $this->entityRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data): ?BaseEntityInterface
    {
        /**@var BaseEntityInterface $baseEntity */
        $baseEntity = $this
            ->formHelper
            ->submitEntity($this->getEntityFormTypeClassName(), $this->getEntity(), $data);

        $this->entityManager->persist($baseEntity);
        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */

        return $this->read($baseEntity->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $data, bool $allProperties = true): ?BaseEntityInterface
    {
        $baseEntity = $this->read($id);

        $this
            ->formHelper
            ->submitEntity($this->getEntityFormTypeClassName(), $baseEntity, $data, $allProperties);

        $this->entityManager->flush();

        /*
         * Get data from repository, not from form.
         */

        return $this->read($baseEntity->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id):void
    {
        $baseEntity = $this->read($id);

        $this->entityManager->remove($baseEntity);
        $this->entityManager->flush();

        return;
    }

    /**
     * Get the form errors in array format.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->formHelper->getErrors();
    }
}
