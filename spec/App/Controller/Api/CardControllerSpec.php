<?php

namespace spec\App\Controller\Api;

use App\Controller\Api\CardController;
use App\Entity\Card;
use App\Repository\CardRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CardControllerSpec extends ObjectBehavior
{
    function let(
        EntityManagerInterface $entityManager,
        FormErrorSerializer $formErrorSerializer,
        CardRepository $cardRepository,
        FormFactoryInterface $formFactory
    )
    {
        $this->beConstructedWith(
            $entityManager,
            $formErrorSerializer,
            $cardRepository,
            $formFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CardController::class);
    }

    function it_should_respond_to_read_action(Card $card)
    {
        $card->jsonSerialize()->willReturn([]);

        $this
            ->read($card)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_list_action(CardRepository $cardRepository)
    {
        $cardRepository->findAll()->willReturn([]);

        $this
            ->list()
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_delete_action(
        Card $card,
        EntityManagerInterface $entityManager
    )
    {
        $entityManager->remove($card)->shouldBeCalledTimes(1);
        $entityManager->flush()->shouldBeCalledTimes(1);

        $this
            ->delete($card)
            ->shouldHaveType(JsonResponse::class);
    }
}
