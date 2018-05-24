<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Controller\Api;

use App\Controller\Api\DeckController;
use App\Entity\Deck;
use App\Helper\JsonHelper;
use App\Helper\JsonResponseHelper;
use App\Manager\DeckManager;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Specification for DeckController.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class DeckControllerSpec extends ObjectBehavior
{
    public function let(
        DeckManager $deckManager,
        JsonHelper $jsonHelper,
        JsonResponseHelper $jsonResponseHelper)
    {
        $this->beConstructedWith($deckManager, $jsonHelper, $jsonResponseHelper);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(DeckController::class);
    }

    public function it_should_respond_to_read_action(
        DeckManager $deckManager,
        Deck $deck,
        JsonResponseHelper $jsonResponseHelper)
    {
        $id = 1;

        $deckManager
            ->read($id)
            ->willReturn($deck);

        $jsonResponseHelper
            ->okResponse($deck)
            ->shouldBeCalledTimes(1);
        $this
            ->read($id)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_list_action(
        DeckManager $deckManager,
        JsonResponseHelper $jsonResponseHelper)
    {
        $decks = [];

        $deckManager
            ->list()
            ->shouldBeCalledTimes(1);

        $jsonResponseHelper
            ->okResponse($decks)
            ->shouldBeCalledTimes(1);

        $this
            ->list()
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_create_action(
        Request $request,
        JsonHelper $jsonHelper,
        DeckManager $deckManager,
        Deck $deck,
        JsonResponseHelper $jsonResponseHelper)
    {
        $jsonContent = '{\n "name":"New Deck"\n}';
        $data = [
            'name' => 'New Deck',
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

        $jsonResponseHelper
            ->createdResponse($deck)
            ->shouldBeCalledTimes(1);

        $this
            ->create($request)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_update_all_action(
        Request $request,
        JsonHelper $jsonHelper,
        DeckManager $deckManager,
        Deck $deck,
        JsonResponseHelper $jsonResponseHelper)
    {
        $id = 1;
        $jsonContent = '{\n "name":"Deck A, version 2"\n}';
        $data = [
            'name' => 'Deck A, version 2',
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

        $jsonResponseHelper
            ->okResponse($deck)
            ->shouldBeCalledTimes(1);

        $this
            ->updateAllProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_update_selected_action(
        Request $request,
        JsonHelper $jsonHelper,
        DeckManager $deckManager,
        Deck $deck,
        JsonResponseHelper $jsonResponseHelper)
    {
        $id = 1;
        $jsonContent = '{\n "name":"Deck A, version 2"\n}';
        $data = [
            'name' => 'Deck A, version 2',
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

        $jsonResponseHelper
            ->okResponse($deck)
            ->shouldBeCalledTimes(1);

        $this
            ->updateSelectedProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_delete_action(
        DeckManager $deckManager,
        JsonResponseHelper $jsonResponseHelper)
    {
        $deckManager
            ->delete(1)
            ->shouldBeCalledTimes(1);

        $jsonResponseHelper
            ->noContentResponse()
            ->shouldBeCalledTimes(1);

        $this
            ->delete(1)
            ->shouldHaveType(JsonResponse::class);
    }
}
