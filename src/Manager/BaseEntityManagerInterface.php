<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use App\Entity\Traits\BaseEntityInterface;

/**
 * Contact for BaseEntity Manager - base CRUD functionality for an entities.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
interface BaseEntityManagerInterface
{
    /**
     * Returns an entity from a repository.
     *
     * @param int $id An entity Id
     *
     * @return BaseEntityInterface The entity
     */
    public function read(int $id): BaseEntityInterface;

    /**
     * Returns all entities from a repository.
     *
     * @return array Collection of entities
     */
    public function list(): array;

    /**
     * Create an entity.
     *
     * @param array $data The data for an entity
     *
     * @return BaseEntityInterface|null The entity
     */
    public function create(array $data): ?BaseEntityInterface;

    /**
     * Update the entity.
     *
     * @param int   $id            The entity Id
     * @param array $data          The data to update
     * @param bool  $allProperties (optional) False to update only selected properties
     *
     * @return BaseEntityInterface|null The entity
     */
    public function update(int $id, array $data, bool $allProperties = true): ?BaseEntityInterface;

    /**
     * Delete entity in a repository.
     *
     * @param int $id The entity Id to delete
     */
    public function delete(int $id): void;
}
