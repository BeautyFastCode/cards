<?php

namespace spec\App\Form;

use App\Entity\Suite;
use App\Form\SuiteType;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuiteTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SuiteType::class);
    }

    function it_can_build_a_form(FormBuilderInterface $builder)
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

    function it_can_correctly_configure_options(OptionsResolver $resolver)
    {
        // Expectations
        $resolver
            ->setDefaults([
                'data_class'      => Suite::class,
                'csrf_protection' => false,
            ])
            ->shouldBeCalledTimes(1);

        $this->configureOptions($resolver);
    }
}
