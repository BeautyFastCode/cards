<?php

namespace spec\App\Manager;

use App\Entity\Deck;
use App\Entity\Suite;
use App\Exception\EntityNotFoundException;
use App\Manager\DeckManager;
use App\Repository\DeckRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;

class DeckManagerSpec extends ObjectBehavior
{
    function let(DeckRepository $deckRepository,
                 EntityManagerInterface $entityManager)
    {
        $this
            ->beConstructedWith(
                $deckRepository,
                $entityManager
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
