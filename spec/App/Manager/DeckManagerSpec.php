<?php

namespace spec\App\Manager;

use App\Entity\Deck;
use App\Entity\Suite;
use App\Exception\EntityNotFoundException;
use App\Form\DeckType;
use App\Helper\FormHelper;
use App\Manager\DeckManager;
use App\Repository\DeckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class DeckManagerSpec extends ObjectBehavior
{
    function let(DeckRepository $deckRepository,
                 EntityManagerInterface $entityManager,
                 FormHelper $formHelper,
                 FormFactoryInterface $formFactory
    )
    {
        $this
            ->beConstructedWith(
                $deckRepository,
                $entityManager,
                $formFactory,
                $formHelper
            );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeckManager::class);
    }

    function it_can_read_one_deck(DeckRepository $deckRepository, Deck $deck)
    {
        $deckRepository
            ->findOneBy(['id' => 1])
            ->willReturn($deck);

        $this
            ->read(1)
            ->shouldReturn($deck);
    }

    function it_can_trow_exception_when_not_find_deck(DeckRepository $deckRepository)
    {
        $deckRepository
            ->findOneBy(['id' => 1000])
            ->willReturn(null);

        $this
            ->shouldThrow(EntityNotFoundException::class)
            ->duringRead(1000);
    }

    function it_can_find_all_decks(DeckRepository $deckRepository)
    {
        $deckRepository
            ->findAll()
            ->willReturn([]);;

        $this
            ->list()
            ->shouldBeArray();
    }

    function it_can_create_deck(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        Deck $deck,
        DeckRepository $deckRepository,
        FormHelper $formHelper)
    {
        $data = ['name' => 'New Deck'];

        $formFactory
            ->create(DeckType::class, new Deck())
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

        $formHelper
            ->formIsNotValid($form)
            ->willReturn(false);

        $form
            ->getData()
            ->willReturn($deck);

        $entityManager
            ->persist($deck)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $deck
            ->getId()
            ->willReturn(1);

        $deckRepository
            ->findOneBy(['id' => 1])
            ->willReturn($deck);

        $this
            ->create($data);

    }

    function it_can_validate_new_data_for_the_create_the_deck(
        FormFactoryInterface $formFactory,
        FormHelper $formHelper,
        FormInterface $form
    )
    {
        $data = [];

        $formFactory
            ->create(DeckType::class, new Deck())
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

        $formHelper
            ->formIsNotValid($form)
            ->willReturn(true);

        $this
            ->create($data);
    }
    
    function it_can_update_all_properties_in_the_deck(
        DeckRepository $deckRepository,
        FormFactoryInterface $formFactory,
        Deck $deck,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        FormHelper $formHelper
    )
    {
        $id = 1;
        $data = ['name' => 'Deck A, version 2'];

        $deckRepository
            ->findOneBy(['id' => 1])
            ->willReturn($deck);

        $formFactory
            ->create(DeckType::class, $deck)
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

        $formHelper
            ->formIsNotValid($form)
            ->willReturn(false);

        $form
            ->getData()
            ->willReturn($deck);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $deck
            ->getId()
            ->willReturn(1);

        $deckRepository
            ->findOneBy(['id' => 1])
            ->willReturn($deck);

        $this
            ->update($id, $data);
    }

     function it_can_update_selected_properties_in_the_deck(
        DeckRepository $deckRepository,
        FormFactoryInterface $formFactory,
        Deck $deck,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        FormHelper $formHelper
    )
    {
        $id = 1;
        $data = ['name' => 'Deck A, version 2'];

        $deckRepository
            ->findOneBy(['id' => 1])
            ->willReturn($deck);

        $formFactory
            ->create(DeckType::class, $deck)
            ->willReturn($form);

        $form
            ->submit($data, false)
            ->shouldBeCalledTimes(1);

        $formHelper
            ->formIsNotValid($form)
            ->willReturn(false);

        $form
            ->getData()
            ->willReturn($deck);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $deck
            ->getId()
            ->willReturn(1);

        $deckRepository
            ->findOneBy(['id' => 1])
            ->willReturn($deck);

        $this
            ->update($id, $data, false);
    }

      function it_can_validate_new_data_for_the_update_the_deck(
        DeckRepository $deckRepository,
        FormFactoryInterface $formFactory,
        Deck $deck,
        FormInterface $form,
        EntityManagerInterface $entityManager,
        FormHelper $formHelper
    )
    {
        $id = 1;
        $data = ['name' => 'Deck A, version 2'];

        $deckRepository
            ->findOneBy(['id' => 1])
            ->willReturn($deck);

        $formFactory
            ->create(DeckType::class, $deck)
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

        $formHelper
            ->formIsNotValid($form)
            ->willReturn(true);

        $this
            ->update($id, $data);
    }

    function it_can_delete_deck(
        EntityManagerInterface $entityManager,
        DeckRepository $deckRepository,
        Deck $deck)
    {
        $suite = new Suite();
        $suites = new ArrayCollection();
        $suites->add($suite);

        $deckRepository
            ->findOneBy(['id' => 1])
            ->willReturn($deck);

        $deck
            ->getSuites()
            ->willReturn($suites);

        $deck
            ->removeSuite($suite)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->remove($deck)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(2);

        $this->delete(1);
    }
}
