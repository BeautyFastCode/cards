<?php

namespace spec\App\Controller\Api;

use App\Controller\Api\SuiteController;
use App\Entity\Suite;
use App\Helper\JsonHelper;
use App\Manager\SuiteManager;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SuiteControllerSpec extends ObjectBehavior
{
    function let(SuiteManager $suiteManager, JsonHelper $jsonHelper)
    {
        $this->beConstructedWith($suiteManager, $jsonHelper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SuiteController::class);
    }

    function it_should_respond_to_read_action(SuiteManager $suiteManager, Suite $suite)
    {
        $id = 1;

        $suiteManager->read($id)->willReturn($suite);
        $suite->jsonSerialize()->willReturn([
            'id'    => 1,
            'name'  => 'Suite A',
            'decks' => [
                1,
                2,
            ],
        ]);

        $this
            ->read($id)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_list_action(SuiteManager $suiteManager)
    {
        $suiteManager->list()->shouldBeCalledTimes(1);

        $this
            ->list()
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_create_action(
        Request $request,
        JsonHelper $jsonHelper,
        SuiteManager $suiteManager,
        Suite $suite
    )
    {
        $jsonContent = '{\n "name":"New Suite"\n}';
        $data = [
            'name'  => 'New Suite'
        ];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $suiteManager
            ->create($data)
            ->willReturn($suite);

        $suite
            ->jsonSerialize()
            ->willReturn([
            'id'    => 1,
            'name'  => 'New Suite',
            'decks' => []
        ]);

        $this
            ->create($request)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_create_action_wrong_content(
        Request $request,
        JsonHelper $jsonHelper,
        SuiteManager $suiteManager
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

        $suiteManager
            ->create($data)
            ->willReturn(null);

        $suiteManager
            ->getErrors()
            ->shouldBeCalledTimes(1);

        $this
            ->create($request)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_update_all_action(
        Request $request,
        JsonHelper $jsonHelper,
        SuiteManager $suiteManager,
        Suite $suite
    )
    {
        $id = 1;
        $jsonContent = '{\n "name":"Suite A, version 2"\n}';
        $data = [
            'name'  => 'Suite A, version 2'
        ];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $suiteManager
            ->update($id, $data)
            ->willReturn($suite);

        $suite
            ->jsonSerialize()
            ->willReturn([
                'id'    => 1,
                'name'  => 'Suite A, version 2',
                'decks' => []
            ]);

        $this
            ->updateAllProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_update_selected_action(
        Request $request,
        JsonHelper $jsonHelper,
        SuiteManager $suiteManager,
        Suite $suite
    )
    {
        $id = 1;
        $jsonContent = '{\n "name":"Suite A, version 2"\n}';
        $data = [
            'name'  => 'Suite A, version 2'
        ];

        $request
            ->getContent()
            ->willReturn($jsonContent);

        $jsonHelper
            ->decode($jsonContent)
            ->willReturn($data);

        $suiteManager
            ->update($id, $data, false)
            ->willReturn($suite);

        $suite
            ->jsonSerialize()
            ->willReturn([
                'id'    => 1,
                'name'  => 'Suite A, version 2',
                'decks' => []
            ]);

        $this
            ->updateSelectedProperties($request, 1)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_delete_action(SuiteManager $suiteManager)
    {
        $suiteManager->delete(1)->shouldBeCalledTimes(1);

        $this
            ->delete(1)
            ->shouldHaveType(JsonResponse::class);
    }
}
