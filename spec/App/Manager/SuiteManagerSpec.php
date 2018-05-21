<?php

namespace spec\App\Manager;

use App\Entity\Deck;
use App\Entity\Suite;
use App\Exception\EntityNotFoundException;
use App\Form\SuiteType;
use App\Manager\SuiteManager;
use App\Repository\SuiteRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class SuiteManagerSpec extends ObjectBehavior
{
    function let(
        SuiteRepository $suiteRepository,
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        FormErrorSerializer $formErrorSerializer
    )
    {
        $this->beConstructedWith(
            $suiteRepository,
            $entityManager,
            $formFactory,
            $formErrorSerializer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SuiteManager::class);
    }

    function it_can_read_one_suite(SuiteRepository $suiteRepository, Suite $suite)
    {
        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $this
            ->read(1)
            ->shouldReturn($suite);
    }

    function it_can_trow_exception_when_not_find_suite(SuiteRepository $suiteRepository)
    {
        $suiteRepository
            ->findOneBy(['id' => 1000])
            ->willReturn(null);

        $this
            ->shouldThrow(EntityNotFoundException::class)
            ->duringRead(1000);
    }

    function it_can_find_all_suites(SuiteRepository $suiteRepository)
    {
        $suiteRepository
            ->findAll()
            ->willReturn([]);;

        $this
            ->list()
            ->shouldBeArray();
    }

    function it_can_create_suite(
        EntityManagerInterface $entityManager,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        Suite $suite,
        SuiteRepository $suiteRepository)
    {
        $data = ['name' => 'New Suite'];

        $formFactory
            ->create(SuiteType::class, new Suite())
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->getData()
            ->willReturn($suite);

        $entityManager
            ->persist($suite)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $suite
            ->getId()
            ->willReturn(1);

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $this
            ->create($data);

    }

    function it_can_validate_new_data_for_the_create_the_suite(
        FormErrorSerializer $formErrorSerializer,
        FormFactoryInterface $formFactory,
        FormInterface $form)
    {
        $data = [];

        $formFactory
            ->create(SuiteType::class, new Suite())
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

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
            ->create($data);
    }

    function it_can_update_all_properties_in_the_suite(
        SuiteRepository $suiteRepository,
        FormFactoryInterface $formFactory,
        Suite $suite,
        FormInterface $form,
        EntityManagerInterface $entityManager
        )
    {
        $id = 1;
        $data = ['name' => 'Suite A, version 2'];

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $formFactory
            ->create(SuiteType::class, $suite)
            ->willReturn($form);

        $form
            ->submit($data)
            ->shouldBeCalledTimes(1);

        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->getData()
            ->willReturn($suite);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $suite
            ->getId()
            ->willReturn(1);

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $this
            ->update($id, $data);
    }

      function it_can_update_selected_properties_in_the_suite(
        SuiteRepository $suiteRepository,
        FormFactoryInterface $formFactory,
        Suite $suite,
        FormInterface $form,
        EntityManagerInterface $entityManager
        )
    {
        $id = 1;
        $data = ['name' => 'Suite A, version 2'];

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $formFactory
            ->create(SuiteType::class, $suite)
            ->willReturn($form);

        $form
            ->submit($data, false)
            ->shouldBeCalledTimes(1);

        $form
            ->isValid()
            ->willReturn(true);

        $form
            ->getData()
            ->willReturn($suite);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $suite
            ->getId()
            ->willReturn(1);

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $this
            ->update($id, $data, false);
    }

    function it_can_validate_new_data_for_the_update_the_suite(
        SuiteRepository $suiteRepository,
        FormErrorSerializer $formErrorSerializer,
        FormFactoryInterface $formFactory,
        FormInterface $form,
        Suite $suite)
    {
        $id = 1;
        $data = [];

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $formFactory
            ->create(SuiteType::class, $suite)
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
            ->update($id, $data);
    }

    function it_can_delete_suite(
        EntityManagerInterface $entityManager,
        SuiteRepository $suiteRepository,
        Suite $suite)
    {
        $deck = new Deck();
        $decks = new ArrayCollection();
        $decks->add($deck);

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $suite
            ->getDecks()
            ->willReturn($decks);

        $suite
            ->removeDeck($deck)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->remove($suite)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(2);

        $this->delete(1);
    }

    function it_can_get_form_errors()
    {
        $this
            ->getErrors()
            ->shouldBeArray();
    }
}
