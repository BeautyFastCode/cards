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
 * Provides Timestampable functionality.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
trait TimestampableTrait
{
    /**
     * Datetime when an entity has been created.
     *
     * @var null|DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * Datetime when an entity has been updated.
     *
     * @var null|DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * {@inheritdoc}
     */
    public function getReadableCreatedAt(): string
    {
        return $this->createdAt->format(DateTimeConstant::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function getReadableUpdatedAt(): string
    {
        return $this->updatedAt->format(DateTimeConstant::FORMAT);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;

        return;
    }
}
