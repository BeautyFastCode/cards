<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
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

/**
 * Specification for DeckManager.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class DeckManagerSpec extends ObjectBehavior
{
    function let(DeckRepository $deckRepository,
                 EntityManagerInterface $entityManager,
                 FormHelper $formHelper)
    {
        $this->beConstructedWith(
                $deckRepository,
                $entityManager,
                $formHelper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeckManager::class);
    }

    function it_can_read_one_deck(
        DeckRepository $deckRepository,
        Deck $deck)
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
        DeckRepository $deckRepository,
        Deck $deck,
        FormHelper $formHelper)
    {
        $data = ['name' => 'New Deck'];

        $formHelper
            ->submitEntity(DeckType::class, new Deck(), $data)
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

    function it_can_update_properties_in_the_deck(
        EntityManagerInterface $entityManager,
        DeckRepository $deckRepository,
        FormHelper $formHelper,
        Deck $deck)
    {
        $id = 1;
        $data = ['name' => 'Deck A, version 2'];

        $deckRepository
            ->findOneBy(['id' => 1])
            ->willReturn($deck);

        $formHelper
            ->submitEntity(DeckType::class, $deck, $data, true)
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

    function it_can_get_form_errors(FormHelper $formHelper)
    {
        $formHelper
            ->getErrors()
            ->willReturn([]);

        $this
            ->getErrors()
            ->shouldBeArray();
    }
}
