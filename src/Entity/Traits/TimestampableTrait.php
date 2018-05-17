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
use App\Constant\DateTimeConstant;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * TimestampableTrait
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
trait TimestampableTrait
{
    /**
     * Datetime when an entity has been created
     *
     * @var null|DateTime
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * Datetime when an entity has been updated
     *
     * @var null|DateTime
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * Returns date of the creation in readable format
     *
     * @return string
     */
    public function getReadableCreatedAt(): string
    {
        return $this->createdAt->format(DateTimeConstant::FORMAT);
    }

    /**
     * Returns date of the update in readable format
     *
     * @return string
     */
    public function getReadableUpdatedAt(): string
    {
        return $this->updatedAt->format(DateTimeConstant::FORMAT);
    }

    /**
     * Returns date of the creation
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * Sets date of the creation
     *
     * @param DateTime $createdAt
     *
     * @return void
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;

        return;
    }

    /**
     * Returns date of last update
     *
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Sets date of last update
     *
     * @param DateTime|null $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;

        return;
    }
}
