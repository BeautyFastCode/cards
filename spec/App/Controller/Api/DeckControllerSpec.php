<?php

namespace spec\App\Controller\Api;

use App\Controller\Api\DeckController;
use App\Entity\Deck;
use App\Helper\JsonHelper;
use App\Manager\DeckManager;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeckControllerSpec extends ObjectBehavior
{
    function let(DeckManager $deckManager, JsonHelper $jsonHelper)
    {
        $this->beConstructedWith($deckManager, $jsonHelper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DeckController::class);
    }

    function it_should_respond_to_read_action(DeckManager $deckManager, Deck $deck)
    {
        $id = 1;

        $deckManager
            ->read($id)
            ->willReturn($deck);

        $deck->jsonSerialize()->willReturn([
            'id'    => 1,
            'name'  => 'Welcome Deck',
            'suites' => [
                1
            ],
            'cards' => [
                1,
                2,
                3
            ]
        ]);

        $this
            ->read($id)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_list_action(DeckManager $deckManager)
    {
        $deckManager
            ->list()
            ->shouldBeCalledTimes(1);

        $this
            ->list()
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_create_action(
        Request $request,
        JsonHelper $jsonHelper,
        DeckManager $deckManager,
        Deck $deck
    )
    {
        $jsonContent = '{\n "name":"New Deck"\n}';
        $data = [
            'name'  => 'New Deck'
        ];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $deckManager
            ->create($data)
            ->willReturn($deck);

        $deck
            ->jsonSerialize()
            ->willReturn([
                'id'    => 1,
                'name'  => 'New Deck',
                'suites' => [],
                'cards' => []
            ]);

        $this
            ->create($request)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_create_action_wrong_content(
        Request $request,
        JsonHelper $jsonHelper,
        DeckManager $deckManager
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

        $deckManager
            ->create($data)
            ->willReturn(null);

        $deckManager
            ->getErrors()
            ->shouldBeCalledTimes(1);

        $this
            ->create($request)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_update_all_action(
        Request $request,
        JsonHelper $jsonHelper,
        DeckManager $deckManager,
        Deck $deck
    )
    {
        $id = 1;
        $jsonContent = '{\n "name":"Deck A, version 2"\n}';
        $data = [
            'name'  => 'Deck A, version 2'
        ];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $deckManager
            ->update($id, $data)
            ->willReturn($deck);

        $deck
            ->jsonSerialize()
            ->willReturn([
                'id'    => 1,
                'name'  => 'Deck A, version 2',
                'suites' => [],
                'cards' => []
            ]);

        $this
            ->updateAllProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_update_selected_action(
        Request $request,
        JsonHelper $jsonHelper,
        DeckManager $deckManager,
        Deck $deck
    )
    {
        $id = 1;
        $jsonContent = '{\n "name":"Deck A, version 2"\n}';
        $data = [
            'name'  => 'Deck A, version 2'
        ];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $deckManager
            ->update($id, $data, false)
            ->willReturn($deck);

        $deck
            ->jsonSerialize()
            ->willReturn([
                'id'    => 1,
                'name'  => 'Deck A, version 2',
                'suites' => [],
                'cards' => []
            ]);

        $this
            ->updateSelectedProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_delete_action(DeckManager $deckManager)
    {
        $deckManager
            ->delete(1)
            ->shouldBeCalledTimes(1);

        $this
            ->delete(1)
            ->shouldHaveType(JsonResponse::class);
    }
}
