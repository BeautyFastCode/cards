<?php

namespace spec\App\Manager;

use App\Entity\Deck;
use App\Entity\Suite;
use App\Exception\EntityNotFoundException;
use App\Manager\SuiteManager;
use App\Repository\SuiteRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormFactoryInterface;

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
