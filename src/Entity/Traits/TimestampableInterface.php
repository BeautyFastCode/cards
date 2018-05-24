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
 * Contract for Timestampable functionality.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
interface TimestampableInterface
{
    /**
     * Returns date of an entity creation in readable format.
     *
     * @return string
     */
    public function getReadableCreatedAt(): string;

    /**
     * Returns date of an entity update in readable format.
     *
     * @return string
     */
    public function getReadableUpdatedAt(): string;

    /**
     * Returns date of an entity creation.
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?\DateTime;

    /**
     * Sets date of an entity creation.
     *
     * @param DateTime $createdAt
     *
     * @return void
     */
    public function setCreatedAt(DateTime $createdAt): void;

    /**
     * Returns date of an entity last update.
     *
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime;

    /**
     * Sets date of an entity last update.
     *
     * @param DateTime|null $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt($updatedAt): void;
}
