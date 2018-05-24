<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Entity\Traits;

use App\Entity\Stubs\SoftDeletableStub;
use App\Entity\Traits\SoftDeletableInterface;
use PhpSpec\ObjectBehavior;
use DateTime;

/**
 * Specification for SoftDeletableTrait.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class SoftDeletableTraitSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(SoftDeletableStub::class);
    }

    public function it_is_soft_deletable()
    {
        $this->shouldImplement(SoftDeletableInterface::class);
    }

    public function it_have_deleted_at_property()
    {
        $datetime = new DateTime();

        $this
            ->getDeletedAt()
            ->shouldReturn(null);

        $this
            ->setDeletedAt($datetime);

        $this
            ->getDeletedAt()
            ->shouldReturn($datetime);
    }

    public function it_can_recover_entity()
    {
        $datetime = new DateTime();

        $this
            ->setDeletedAt($datetime);

        $this
            ->getDeletedAt()
            ->shouldReturn($datetime);

        // Recover
        $this
            ->recover();

        $this
            ->getDeletedAt()
            ->shouldReturn(null);
    }

    public function it_can_check_if_entity_is_deleted()
    {
        $this
            ->isDeleted()
            ->shouldReturn(false);
    }

    public function it_can_check_if_entity_is_not_deleted()
    {
        $this
            ->isNotDeleted()
            ->shouldReturn(true);
    }
}
