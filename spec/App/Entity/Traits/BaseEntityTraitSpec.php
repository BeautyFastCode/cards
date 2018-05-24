<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Entity\Traits;

use App\Entity\Stubs\BaseEntityTraitStub;
use App\Entity\Traits\BaseEntityInterface;
use PhpSpec\ObjectBehavior;

/**
 * Specification for BaseEntityTrait.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class BaseEntityTraitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(BaseEntityTraitStub::class);
    }

    function it_have_base_interface()
    {
        $this->shouldImplement(BaseEntityInterface::class);
    }

    function it_have_id_property()
    {
        $this->getId()->shouldReturn(null);
    }
}
