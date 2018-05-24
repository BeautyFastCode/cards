<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Traits;

use DateTime;

/**
 * Contract for SoftDeletable functionality.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
interface SoftDeletableInterface
{
    /**
     * Returns true if an entity is deleted.
     *
     * @return bool
     */
    public function isDeleted(): bool;

    /**
     * Returns true if an entity is not deleted.
     *
     * @return bool
     */
    public function isNotDeleted(): bool;

    /**
     * Recover an entity.
     */
    public function recover(): void;

    /**
     * Sets date of an entity deletion.
     *
     * @param DateTime $deletedAt
     */
    public function setDeletedAt(DateTime $deletedAt): void;

    /**
     * Returns date of an entity deletion.
     *
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime;
}
