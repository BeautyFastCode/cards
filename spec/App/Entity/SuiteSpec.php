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

    function it_is_json_serializable()
    {
        $this->shouldImplement('JsonSerializable');
    }

    function it_returns_object_as_an_array()
    {
        $this->jsonSerialize()->shouldHaveKey('id');
        $this->jsonSerialize()->shouldHaveKey('name');
        $this->jsonSerialize()->shouldHaveKey('decks');
    }
}
