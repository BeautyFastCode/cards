<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Entity\Traits\BaseEntityInterface;
use App\Entity\Traits\BaseEntityTrait;
use App\Entity\Traits\SoftDeletableInterface;
use App\Entity\Traits\SoftDeletableTrait;
use App\Entity\Traits\TimestampableInterface;
use App\Entity\Traits\TimestampableTrait;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * BaseEntity
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
abstract class BaseEntity implements BaseEntityInterface, SoftDeletableInterface, TimestampableInterface
{
    /**
     * Unique identifier - id field
     */
    use BaseEntityTrait;

    /**
     * SoftDeletable behavior - deletedAt field
     */
    use SoftDeletableTrait;

    /**
     * Timestampable behavior - createdAt and updatedAt fields
     */
    use TimestampableTrait;
}
