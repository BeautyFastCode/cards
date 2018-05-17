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
 * TimestampableInterface
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
interface TimestampableInterface
{
    /**
     * Returns date of the creation in readable format
     *
     * @return string
     */
    public function getReadableCreatedAt(): string;

    /**
     * Returns date of the update in readable format
     *
     * @return string
     */
    public function getReadableUpdatedAt(): string;

    /**
     * Returns date of the creation
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?\DateTime;

    /**
     * Sets date of the creation
     *
     * @param DateTime $createdAt
     *
     * @return void
     */
    public function setCreatedAt(DateTime $createdAt): void;

    /**
     * Returns date of last update
     *
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime;

    /**
     * Sets date of last update
     *
     * @param DateTime|null $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt($updatedAt): void;
}
