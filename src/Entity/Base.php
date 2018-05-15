<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * BaseEntity
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
abstract class Base implements BaseInterface, SoftDeletableInterface, TimestampableInterface
{
    /**
     * Unique identifier - id field
     */
    use BaseTrait;

    /**
     * SoftDeletable behavior - deletedAt field
     */
    use SoftDeletableTrait;

    /**
     * Timestampable behavior - createdAt and updatedAt fields
     */
    use TimestampableTrait;
}
