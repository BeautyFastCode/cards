<?php

namespace spec\App\Exception;

use App\Exception\EntityNotFoundException;
use PhpSpec\ObjectBehavior;

class EntityNotFoundExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Suite', 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EntityNotFoundException::class);
    }
}
