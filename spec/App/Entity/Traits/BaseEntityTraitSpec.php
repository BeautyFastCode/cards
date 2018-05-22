<?php

namespace spec\App\Entity\Traits;

use App\Entity\Stubs\BaseEntityStub;
use App\Entity\Traits\BaseEntityInterface;
use PhpSpec\ObjectBehavior;

class BaseEntityTraitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(BaseEntityStub::class);
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
