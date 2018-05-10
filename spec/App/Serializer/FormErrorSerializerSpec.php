<?php

namespace spec\App\Serializer;

use App\Serializer\FormErrorSerializer;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;

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
        //
        $data->getErrors()->willReturn([]);
        $data->all()->willReturn([]);

        //
        $this->convertFormToArray($data)->shouldReturn([]);
    }

    function it_can_convert_form_errors_to_array_2(FormInterface $data, FormError $error)
    {
        //
        $data->getErrors()->willReturn([$error]);
        $data->all()->willReturn([]);

        //
        $error->getMessagePluralization()->shouldBeCalled();
        $error->getMessageTemplate()->shouldBeCalled();
        $error->getMessageParameters()->shouldBeCalled();

        //
        $error->getMessagePluralization()->willReturn(null);
        $error->getMessageParameters()->willReturn([]);

        //
        $this
            ->convertFormToArray($data)
            ->shouldReturn([
                'errors' => [
                    null,
                ],
            ]);
    }

    // with child

    function it_can_get_error_message_with_pluralization_from_translator(FormInterface $data, FormError $error)
    {
        //
        $data->getErrors()->willReturn([$error]);
        $data->all()->willReturn([]);

        //
        $error->getMessagePluralization()->shouldBeCalled();
        $error->getMessageTemplate()->shouldBeCalled();
        $error->getMessageParameters()->shouldBeCalled();

        //
        $error->getMessagePluralization()->willReturn(1);
        $error->getMessageParameters()->willReturn([]);

        //
        $this
            ->convertFormToArray($data)
            ->shouldReturn([
                'errors' => [
                    null,
                ],
            ]);
    }
}
