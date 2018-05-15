<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use DateTime;

/**
 * SoftDeletableTrait
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
trait SoftDeletableTrait
{
    /**
     * Datetime when an entity has been removed
     *
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Returns true if entity is deleted
     *
     * @return bool
     */
    public function isDeleted():bool
    {
        return isset($this->deletedAt);
    }

    /**
     * Returns true if entity is not deleted
     *
     * @return bool
     */
    public function isNotDeleted():bool
    {
        return !$this->isDeleted();
    }

    /**
     * Recover an entity
     *
     * @return void
     */
    public function recover(): void
    {
        $this->deletedAt = null;

        return;
    }

    /**
     * Sets date of deletion
     *
     * @param DateTime $deletedAt
     *
     * @return void
     */
    public function setDeletedAt(DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;

        return;
    }

    /**
     * Returns date of deletion
     *
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }
}
