<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Stubs;

use App\Entity\Traits\BaseInterface;
use App\Entity\Traits\BaseTrait;

/**
 * BaseStub
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class BaseStub implements BaseInterface
{
    /**
     * Unique identifier - id field
     */
    use BaseTrait;
}
