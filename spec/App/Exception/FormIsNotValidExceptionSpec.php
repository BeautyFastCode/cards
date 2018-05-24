<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Exception;

use App\Exception\FormIsNotValidException;
use PhpSpec\ObjectBehavior;

/**
 * Specification for FormIsNotValidException.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class FormIsNotValidExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([
            'error' => 'This value should not be blank.',
            ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(FormIsNotValidException::class);
    }

    public function it_can_get_form_errors()
    {
        $this->getFormErrors()
            ->shouldReturn([
                'error' => 'This value should not be blank.',
            ]);
    }
}
