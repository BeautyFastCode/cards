<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Stubs;

use App\Entity\Traits\SoftDeletableInterface;
use App\Entity\Traits\SoftDeletableTrait;

/**
 * SoftDeletableStub
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class SoftDeletableStub implements SoftDeletableInterface
{
    /**
     * SoftDeletable behavior - deletedAt field
     */
    use SoftDeletableTrait;
}
