<?php

namespace spec\App\Controller\Api;

use App\Controller\Api\DeckController;
use App\Entity\Deck;
use App\Entity\Suite;
use App\Repository\DeckRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeckControllerSpec extends ObjectBehavior
{
    function let(
        EntityManagerInterface $entityManager,
        FormErrorSerializer $formErrorSerializer,
        DeckRepository $deckRepository,
        FormFactory $formFactory
    )
    {
        $this->beConstructedWith(
            $entityManager,
            $formErrorSerializer,
            $deckRepository,
            $formFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeckController::class);
    }

    function it_should_respond_to_read_action(Deck $deck)
    {
        $deck->jsonSerialize()->willReturn([]);

        $this
            ->read($deck)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_list_action(DeckRepository $deckRepository)
    {
        $deckRepository->findAll()->willReturn([]);

        $this
            ->list()
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_delete_action(
        Deck $deck,
        EntityManagerInterface $entityManager
    )
    {
        $deck->getSuites()->willReturn(new ArrayCollection());

        $entityManager->remove($deck)->shouldBeCalledTimes(1);
        $entityManager->flush()->shouldBeCalledTimes(2);

        $this
            ->delete($deck)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_delete_action_2(
        Deck $deck,
        EntityManagerInterface $entityManager
    )
    {
        // Prepare data
        $suite = new Suite();
        $suites = new ArrayCollection();
        $suites->add($suite);

        // Promise
        $deck->getSuites()->willReturn($suites);

        // Expectations
        $deck->removeSuite($suite)->shouldBeCalledTimes(1);

        $entityManager->remove($deck)->shouldBeCalledTimes(1);
        $entityManager->flush()->shouldBeCalledTimes(2);

        // Delete
        $this
            ->delete($deck)
            ->shouldHaveType(JsonResponse::class);
    }
}
