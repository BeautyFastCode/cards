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
use Doctrine\Common\Persistence\ObjectRepository;

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
     * Class constructor
     *
     * @param ObjectRepository $entityRepository
     */
    public function __construct(ObjectRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

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
            throw new EntityNotFoundException('Suite', $id);
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
}
