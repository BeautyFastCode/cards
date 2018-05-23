<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Helper;

use App\Helper\JsonHelper;
use PhpSpec\ObjectBehavior;

/**
 * Specification for JsonHelper.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
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
