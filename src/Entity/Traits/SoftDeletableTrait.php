<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Provides SoftDeletable functionality.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
trait SoftDeletableTrait
{
    /**
     * Datetime when an entity has been removed.
     *
     * @var DateTime|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * {@inheritdoc}
     */
    public function isDeleted(): bool
    {
        return isset($this->deletedAt);
    }

    /**
     * {@inheritdoc}
     */
    public function isNotDeleted(): bool
    {
        return !$this->isDeleted();
    }

    /**
     * {@inheritdoc}
     */
    public function recover(): void
    {
        $this->deletedAt = null;

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeletedAt(DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }
}
