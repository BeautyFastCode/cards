<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Helper;

use App\Entity\Traits\BaseEntityInterface;
use App\Exception\FormIsNotValidException;
use App\Helper\FormHelper;
use App\Serializer\FormErrorSerializer;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Specification for FormHelper.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class FormHelperSpec extends ObjectBehavior
{
    function let(
        FormFactoryInterface $formFactory,
        FormErrorSerializer $formErrorSerializer)
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
        BaseEntityInterface $baseEntity)
    {
        $data = ['name' => 'New Entity'];

        $formFactory
            ->create(FormType::class, $baseEntity)
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->getData()
            ->willReturn($baseEntity);

        $this
            ->submitEntity(FormType::class, $baseEntity, $data)
            ->shouldReturn($baseEntity);
    }

    function it_can_submit_an_entity_selected_properties(
        FormFactoryInterface $formFactory,
        FormInterface $form,
        BaseEntityInterface $baseEntity)
    {
        $data = ['name' => 'New Entity'];
        $allProperties = false;

        $formFactory
            ->create(FormType::class, $baseEntity)
            ->willReturn($form);

        $form
            ->submit($data, $allProperties)
            ->shouldBeCalledTimes(1);

        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->getData()
            ->willReturn($baseEntity);

        $this
            ->submitEntity(FormType::class, $baseEntity, $data, $allProperties)
            ->shouldReturn($baseEntity);
    }

    function it_can_submit_and_validate_an_entity(
        FormErrorSerializer $formErrorSerializer,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        BaseEntityInterface $baseEntity)
    {
        $data = ['name' => 'New Entity'];

        $formFactory
            ->create(FormType::class, $baseEntity)
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
            ->shouldThrow(FormIsNotValidException::class)
            ->duringSubmitEntity(FormType::class, $baseEntity, $data);
    }

    function it_can_get_form_errors()
    {
        $this
            ->getErrors()
            ->shouldBeArray();
    }
}
