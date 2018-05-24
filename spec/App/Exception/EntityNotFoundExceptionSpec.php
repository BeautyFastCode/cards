<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Exception;

use App\Exception\EntityNotFoundException;
use PhpSpec\ObjectBehavior;

/**
 * Specification for EntityNotFoundException.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class EntityNotFoundExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('Suite', 1);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EntityNotFoundException::class);
    }
}
