<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Traits;

/**
 * Contract for BaseEntity class.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
interface BaseEntityInterface
{
    /**
     * Returns an entity Id.
     *
     * @return null|int
     */
    public function getId(): ?int;
}
