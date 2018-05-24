<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Form;

use App\Entity\Deck;
use App\Form\DeckType;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Specification for DeckType.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class DeckTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DeckType::class);
    }

    public function it_can_build_a_form(FormBuilderInterface $builder)
    {
        // Promises & Expectations
        $builder
            ->add('name')
            ->willReturn($builder);

        $builder
            ->add('suites')
            ->willReturn($builder);

        $builder
            ->add('name')
            ->shouldBeCalledTimes(1);

        $builder
            ->add('suites')
            ->shouldBeCalledTimes(1);

        $builder
            ->add('cards')
            ->shouldBeCalledTimes(1);

        $this->buildForm($builder, []);
    }

    public function it_can_correctly_configure_options(OptionsResolver $resolver)
    {
        // Expectations
        $resolver
            ->setDefaults([
                'data_class' => Deck::class,
                'csrf_protection' => false,
            ])
            ->shouldBeCalledTimes(1);

        $this->configureOptions($resolver);
    }
}
