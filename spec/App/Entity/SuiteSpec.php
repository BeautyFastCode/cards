<?php

namespace spec\App\Entity;

use App\Entity\Suite;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SuiteSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Suite::class);
    }
}
