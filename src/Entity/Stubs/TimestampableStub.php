<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Stubs;

use App\Entity\Traits\TimestampableInterface;
use App\Entity\Traits\TimestampableTrait;

/**
 * TimestampableStub
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class TimestampableStub implements TimestampableInterface
{
    /**
     * Timestampable behavior - createdAt and updatedAt fields
     */
    use TimestampableTrait;
}
