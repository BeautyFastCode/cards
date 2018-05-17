<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Traits;

use DateTime;

/**
 * SoftDeletableInterface
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
interface SoftDeletableInterface
{
    /**
     * Returns true if entity is deleted
     *
     * @return bool
     */
    public function isDeleted():bool;

    /**
     * Returns true if entity is not deleted
     *
     * @return bool
     */
    public function isNotDeleted():bool;

    /**
     * Recover an entity
     *
     * @return void
     */
    public function recover(): void;

    /**
     * Sets date of deletion
     *
     * @param DateTime $deletedAt
     *
     * @return void
     */
    public function setDeletedAt(DateTime $deletedAt): void;

    /**
     * Returns date of deletion
     *
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime;
}
