<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Entity\Traits;

use App\Constant\DateTimeConstant;
use App\Entity\Stubs\TimestampableStub;
use App\Entity\Traits\TimestampableInterface;
use DateTime;
use PhpSpec\ObjectBehavior;

/**
 * TimestampableTraitSpec
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class TimestampableTraitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(TimestampableStub::class);
    }

    function it_is_timestampable()
    {
        $this->shouldImplement(TimestampableInterface::class);
    }

    function it_have_created_at_property()
    {
        $datetime = new DateTime();

        $this->getCreatedAt()->shouldReturn(null);

        $this->setCreatedAt($datetime);
        $this->getCreatedAt()->shouldReturn($datetime);
    }
    
    function it_have_updated_at_property()
    {
        $datetime = new DateTime();

        $this->getUpdatedAt()->shouldReturn(null);

        $this->setUpdatedAt($datetime);
        $this->getUpdatedAt()->shouldReturn($datetime);
    }

    function it_can_returns_date_of_creation_in_readable_format()
    {
        $readable = '17/05/2018 14:18';

        // FORMAT d/m/Y H:i

        $datetime = DateTime::createFromFormat(DateTimeConstant::FORMAT, $readable);

        $this->setCreatedAt($datetime);
        $this->getReadableCreatedAt()->shouldReturn($readable);
    }

    function it_can_returns_date_of_update_in_readable_format()
    {
        $readable = '17/05/2018 14:18';

        // FORMAT d/m/Y H:i

        $datetime = DateTime::createFromFormat(DateTimeConstant::FORMAT, $readable);

        $this->setUpdatedAt($datetime);
        $this->getReadableUpdatedAt()->shouldReturn($readable);
    }
}
