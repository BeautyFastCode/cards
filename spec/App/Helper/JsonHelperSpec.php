<?php

namespace spec\App\Helper;

use App\Helper\JsonHelper;
use PhpSpec\ObjectBehavior;

class JsonHelperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JsonHelper::class);
    }

    function it_can_decode_json_to_array()
    {
        $this
            ->decode('{}')
            ->shouldBeArray();
    }

    function it_can_decode_json_to_array_2()
    {
        $jsonContent = '{"name":"New Suite"}';
        $data = [
            'name' => 'New Suite',
        ];

        $this
            ->decode($jsonContent)
            ->shouldReturn($data);
    }
}
