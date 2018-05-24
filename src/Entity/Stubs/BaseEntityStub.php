<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Stubs;

use App\Entity\Traits\BaseEntityInterface;
use App\Entity\Traits\BaseEntityTrait;

/**
 * Stub for BaseEntity trait used in specifications.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class BaseEntityStub implements BaseEntityInterface
{
    /**
     * Unique identifier - id field
     */
    use BaseEntityTrait;
}
