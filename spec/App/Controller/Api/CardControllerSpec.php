<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Controller\Api;

use App\Controller\Api\CardController;
use App\Entity\Card;
use App\Helper\JsonHelper;
use App\Helper\JsonResponseHelper;
use App\Manager\CardManager;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Specification for CardController.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class CardControllerSpec extends ObjectBehavior
{
    public function let(
        CardManager $cardManager,
        JsonHelper $jsonHelper,
        JsonResponseHelper $jsonResponseHelper)
    {
        $this->beConstructedWith($cardManager, $jsonHelper, $jsonResponseHelper);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CardController::class);
    }

    public function it_should_respond_to_read_action(
        CardManager $cardManager,
        Card $card,
        JsonResponseHelper $jsonResponseHelper)
    {
        $id = 1;

        $cardManager
            ->read($id)
            ->willReturn($card);

        $jsonResponseHelper
            ->okResponse($card)
            ->shouldBeCalledTimes(1);

        $this
            ->read($id)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_list_action(
        CardManager $cardManager,
        JsonResponseHelper $jsonResponseHelper)
    {
        $cards = [];

        $cardManager
            ->list()
            ->willReturn($cards);

        $jsonResponseHelper
            ->okResponse($cards)
            ->shouldBeCalledTimes(1);

        $this
            ->list()
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_create_action(
        Request $request,
        JsonHelper $jsonHelper,
        CardManager $cardManager,
        Card $card,
        JsonResponseHelper $jsonResponseHelper)
    {
        $jsonContent = '{"question":"Where are you?","answer":"I\'m here"}';
        $data = [
            'question' => 'Where are you?',
            'answer' => 'I\'m here',
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

        $jsonResponseHelper
            ->createdResponse($card)
            ->shouldBeCalledTimes(1);

        $this
            ->create($request)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_update_all_action(
        Request $request,
        JsonHelper $jsonHelper,
        CardManager $cardManager,
        Card $card,
        JsonResponseHelper $jsonResponseHelper)
    {
        $id = 1;
        $jsonContent = '{"question":"Where are you?","answer":"I\'m here"}';
        $data = [
            'question' => 'Where are you?',
            'answer' => 'I\'m here',
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

        $jsonResponseHelper
            ->okResponse($card)
            ->shouldBeCalledTimes(1);

        $this
            ->updateAllProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_update_selected_action(
        Request $request,
        JsonHelper $jsonHelper,
        CardManager $cardManager,
        Card $card,
        JsonResponseHelper $jsonResponseHelper)
    {
        $id = 1;
        $jsonContent = '{"question":"Where are you?","answer":"I\'m here"}';
        $data = [
            'question' => 'Where are you?',
            'answer' => 'I\'m here',
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

        $jsonResponseHelper
            ->okResponse($card)
            ->shouldBeCalledTimes(1);

        $this
            ->updateSelectedProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_delete_action(
        CardManager $cardManager,
        JsonResponseHelper $jsonResponseHelper)
    {
        $cardManager
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
