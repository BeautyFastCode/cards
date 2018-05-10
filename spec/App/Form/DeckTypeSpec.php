<?php

namespace spec\App\Form;

use App\Entity\Deck;
use App\Form\DeckType;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\Test\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeckTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DeckType::class);
    }

    function it_can_build_a_form(FormBuilderInterface $builder)
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

    function it_can_correctly_configure_options(OptionsResolver $resolver)
    {
        // Expectations
        $resolver
            ->setDefaults([
                'data_class'      => Deck::class,
                'csrf_protection' => false,
            ])
            ->shouldBeCalledTimes(1);

        $this->configureOptions($resolver);
    }
}
