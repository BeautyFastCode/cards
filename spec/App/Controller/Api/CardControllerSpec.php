<?php

namespace spec\App\Controller\Api;

use App\Controller\Api\CardController;
use App\Entity\Card;
use App\Helper\JsonHelper;
use App\Manager\CardManager;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CardControllerSpec extends ObjectBehavior
{
    function let(CardManager $cardManager, JsonHelper $jsonHelper)
    {
        $this->beConstructedWith($cardManager, $jsonHelper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CardController::class);
    }

    function it_should_respond_to_read_action(CardManager $cardManager, Card $card)
    {
        $id = 1;

        $cardManager
            ->read($id)
            ->willReturn($card);

        $card->jsonSerialize()->willReturn([
            'id'    => 1,
            'question'  => 'Front Card',
            'answer'  => 'Back Card',
            'deck' => 1,
        ]);

        $this
            ->read($id)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_list_action(CardManager $cardManager)
    {
        $cardManager
            ->list()
            ->shouldBeCalledTimes(1);

        $this
            ->list()
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_create_action(
        Request $request,
        JsonHelper $jsonHelper,
        CardManager $cardManager,
        Card $card
    )
    {
        $jsonContent = '{"question":"Where are you?","answer":"I\'m here"}';
        $data = [
            'question'  => 'Where are you?',
            'answer' => 'I\'m here'
        ];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $cardManager
            ->create($data)
            ->willReturn($card);

        $card
            ->jsonSerialize()
            ->willReturn([
                'id'    => 1,
                'question'  => 'Where are you?',
                'answer' => 'I\'m here',
                'deck' => null
            ]);

        $this
            ->create($request)
            ->shouldHaveType(JsonResponse::class);
    }
    
    function it_should_respond_to_create_action_wrong_content(
        Request $request,
        JsonHelper $jsonHelper,
        CardManager $cardManager
    )
    {
        $jsonContent = '{\n \n}';
        $data = [];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $cardManager
            ->create($data)
            ->willReturn(null);

        $this
            ->create($request)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_update_all_action(
        Request $request,
        JsonHelper $jsonHelper,
        CardManager $cardManager,
        Card $card
    )
    {
        $id = 1;
        $jsonContent = '{"question":"Where are you?","answer":"I\'m here"}';
        $data = [
            'question'  => 'Where are you?',
            'answer' => 'I\'m here'
        ];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $cardManager
            ->update($id, $data)
            ->willReturn($card);

        $card
            ->jsonSerialize()
            ->willReturn([
                'id'    => 1,
                'question'  => 'Where are you?',
                'answer' => 'I\'m here',
                'deck' => null
            ]);

        $this
            ->updateAllProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

     function it_should_respond_to_update_selected_action(
        Request $request,
        JsonHelper $jsonHelper,
        CardManager $cardManager,
        Card $card
    )
    {
        $id = 1;
        $jsonContent = '{"question":"Where are you?","answer":"I\'m here"}';
        $data = [
            'question'  => 'Where are you?',
            'answer' => 'I\'m here'
        ];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $cardManager
            ->update($id, $data, false)
            ->willReturn($card);

        $card
            ->jsonSerialize()
            ->willReturn([
                'id'    => 1,
                'question'  => 'Where are you?',
                'answer' => 'I\'m here',
                'deck' => null
            ]);

        $this
            ->updateSelectedProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_delete_action(CardManager $cardManager)
    {
        $cardManager
            ->delete(1)
            ->shouldBeCalledTimes(1);

        $this
            ->delete(1)
            ->shouldHaveType(JsonResponse::class);
    }
}
