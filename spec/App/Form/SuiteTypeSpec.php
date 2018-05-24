<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Form;

use App\Entity\Suite;
use App\Form\SuiteType;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Specification for SuiteType.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class SuiteTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SuiteType::class);
    }

    public function it_can_build_a_form(FormBuilderInterface $builder)
    {
        // Promises & Expectations
        $builder
            ->add('name')
            ->willReturn($builder);

        $builder
            ->add('name')
            ->shouldBeCalledTimes(1);

        $builder
            ->add('decks')
            ->shouldBeCalledTimes(1);

        $this->buildForm($builder, []);
    }

    public function it_can_correctly_configure_options(OptionsResolver $resolver)
    {
        // Expectations
        $resolver
            ->setDefaults([
                'data_class' => Suite::class,
                'csrf_protection' => false,
            ])
            ->shouldBeCalledTimes(1);

        $this->configureOptions($resolver);
    }
}
