<?php

namespace spec\App\Helper;

use App\Entity\Deck;
use App\Form\DeckType;
use App\Helper\FormHelper;
use App\Serializer\FormErrorSerializer;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FormHelperSpec extends ObjectBehavior
{
    function let(
        FormFactoryInterface $formFactory,
        FormErrorSerializer $formErrorSerializer
    )
    {
        $this->beConstructedWith($formFactory, $formErrorSerializer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FormHelper::class);
    }

    function it_can_submit_an_entity(
        FormFactoryInterface $formFactory,
        FormInterface $form,
        Deck $deck
    )
    {
        $data = ['name' => 'New Entity'];

        $formFactory
            ->create(DeckType::class, new Deck())
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->getData()
            ->willReturn($deck);

        $this
            ->submitEntity(DeckType::class, new Deck(), $data)
            ->shouldReturn($deck);
    }

    function it_can_submit_an_entity_selected_properties(
        FormFactoryInterface $formFactory,
        FormInterface $form,
        Deck $deck
    )
    {
        $data = ['name' => 'New Entity'];
        $allProperties = false;

        $formFactory
            ->create(DeckType::class, new Deck())
            ->willReturn($form);

        $form
            ->submit($data, $allProperties)
            ->shouldBeCalledTimes(1);

        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->getData()
            ->willReturn($deck);

        $this
            ->submitEntity(DeckType::class, new Deck(), $data, $allProperties)
            ->shouldReturn($deck);
    }

    function it_can_submit_and_validate_an_entity(
        FormErrorSerializer $formErrorSerializer,
        FormFactoryInterface $formFactory,
        FormInterface $form
    )
    {
        $data = ['name' => 'New Entity'];

        $formFactory
            ->create(DeckType::class, new Deck())
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

        $form
            ->isValid()
            ->willReturn(false);

        $formErrorSerializer
            ->convertFormToArray($form)
            ->willReturn([]);

        $this
            ->submitEntity(DeckType::class, new Deck(), $data)
            ->shouldReturn(null);
    }

    function it_can_get_form_errors()
    {
        $this
            ->getErrors()
            ->shouldBeArray();
    }
}
