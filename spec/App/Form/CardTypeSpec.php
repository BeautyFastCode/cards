<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Form;

use App\Entity\Card;
use App\Form\CardType;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Specification for CardType.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class CardTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CardType::class);
    }

    function it_can_build_a_form(FormBuilderInterface $builder)
    {
        // Promises & Expectations
        $builder
            ->add('question')
            ->willReturn($builder);

        $builder
            ->add('answer')
            ->willReturn($builder);

        $builder
            ->add('question')
            ->shouldBeCalledTimes(1);

        $builder
            ->add('answer')
            ->shouldBeCalledTimes(1);

        $builder
            ->add('deck')
            ->shouldBeCalledTimes(1);

        $this->buildForm($builder, []);
    }

    function it_can_correctly_configure_options(OptionsResolver $resolver)
    {
        // Expectations
        $resolver
            ->setDefaults([
                'data_class'      => Card::class,
                'csrf_protection' => false,
            ])
            ->shouldBeCalledTimes(1);

        $this->configureOptions($resolver);
    }
}
