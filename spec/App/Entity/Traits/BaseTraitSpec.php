<?php

namespace spec\App\Entity\Traits;

use App\Entity\Stubs\BaseStub;
use PhpSpec\ObjectBehavior;

class BaseTraitSpec extends ObjectBehavior
{
    function let()
    {
        $this->beAnInstanceOf(BaseStub::class);
    }

    function it_have_id_property()
    {
        $this->getId()->shouldReturn(null);
    }
}
