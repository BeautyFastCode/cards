<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Serializer;

use App\Serializer\FormErrorSerializer;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Specification for FormErrorSerializer.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class FormErrorSerializerSpec extends ObjectBehavior
{
    function let(TranslatorInterface $translator)
    {
        $this->beConstructedWith($translator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FormErrorSerializer::class);
    }

    function it_can_convert_form_errors_to_array(FormInterface $data)
    {
        $data
            ->getErrors()
            ->willReturn([]);

        $data
            ->all()
            ->willReturn([]);

        $this
            ->convertFormToArray($data)
            ->shouldReturn([]);
    }

    function it_can_convert_child_errors(
        FormInterface $data,
        FormError $error)
    {
        $data
            ->getErrors()
            ->willReturn([]);

        $data
            ->all()
            ->willReturn([$error]);

        /*
         * Expectation
         */
        $this
            ->convertFormToArray($data)
            ->shouldReturn([]);
    }

    function it_can_convert_form_errors_to_array_2(
        FormInterface $data,
        FormError $error)
    {
        //
        $data
            ->getErrors()
            ->willReturn([$error]);

        $data
            ->all()
            ->willReturn([]);

        /*
         * getErrorMessage - without pluralization
         */
        $error
            ->getMessagePluralization()
            ->shouldBeCalled();

        $error
            ->getMessageTemplate()
            ->shouldBeCalled();

        $error
            ->getMessageParameters()
            ->shouldBeCalled();

        //
        $error
            ->getMessagePluralization()
            ->willReturn(null);

        $error
            ->getMessageParameters()
            ->willReturn([]);

        /*
         * Expectation
         */
        $this
            ->convertFormToArray($data)
            ->shouldReturn([
                'errors' => [
                    null,
                ],
            ]);
    }

    function it_can_convert_form_errors_to_array_3(
        FormInterface $data,
        TranslatorInterface $translator)
    {
        $error = new FormError("This value should not be blank.");
        $data->addError($error);

        $data
            ->getErrors()
            ->willReturn([$error]);

        $data
            ->all()
            ->willReturn([]);

        $translator->trans($error->getMessageTemplate(), $error->getMessageParameters(), 'validators')
            ->willReturn("This value should not be blank.");

        /*
         * Expectation
         */
        $this
            ->convertFormToArray($data)
            ->shouldReturn([
                'errors' => [
                    'This value should not be blank.',
                ],
            ]);
    }

    function it_can_get_error_message_with_pluralization_from_translator(
        FormInterface $data,
        FormError $error)
    {
        $data
            ->getErrors()
            ->willReturn([$error]);

        $data
            ->all()
            ->willReturn([]);

        /*
         * getErrorMessage - with pluralization
         */
        $error
            ->getMessagePluralization()
            ->willReturn(1);

        $error
            ->getMessageTemplate()
            ->shouldBeCalled();

        $error
            ->getMessageParameters()
            ->willReturn([]);

        /*
         * Expectation
         */
        $this
            ->convertFormToArray($data)
            ->shouldReturn([
                'errors' => [
                    null,
                ],
            ]);
    }
}
