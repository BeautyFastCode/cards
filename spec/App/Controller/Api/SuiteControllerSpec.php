<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Controller\Api;

use App\Controller\Api\SuiteController;
use App\Entity\Suite;
use App\Helper\JsonHelper;
use App\Helper\JsonResponseHelper;
use App\Manager\SuiteManager;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Specification for SuiteController.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class SuiteControllerSpec extends ObjectBehavior
{
    public function let(
        SuiteManager $suiteManager,
        JsonHelper $jsonHelper,
        JsonResponseHelper $jsonResponseHelper)
    {
        $this->beConstructedWith($suiteManager, $jsonHelper, $jsonResponseHelper);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SuiteController::class);
    }

    public function it_should_respond_to_read_action(
        SuiteManager $suiteManager,
        Suite $suite,
        JsonResponseHelper $jsonResponseHelper)
    {
        $id = 1;

        $suiteManager
            ->read($id)
            ->willReturn($suite);

        $jsonResponseHelper
            ->okResponse($suite)
            ->shouldBeCalledTimes(1);

        $this
            ->read($id)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_list_action(
        SuiteManager $suiteManager,
        JsonResponseHelper $jsonResponseHelper)
    {
        $suites = [];

        $suiteManager
            ->list()
            ->willReturn($suites);

        $jsonResponseHelper
            ->okResponse($suites)
            ->shouldBeCalledTimes(1);

        $this
            ->list()
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_create_action(
        Request $request,
        JsonHelper $jsonHelper,
        SuiteManager $suiteManager,
        Suite $suite,
        JsonResponseHelper $jsonResponseHelper)
    {
        $jsonContent = '{\n "name":"New Suite"\n}';
        $data = [
            'name' => 'New Suite',
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

        $jsonResponseHelper
            ->createdResponse($suite)
            ->shouldBeCalledTimes(1);

        $this
            ->create($request)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_update_all_action(
        Request $request,
        JsonHelper $jsonHelper,
        SuiteManager $suiteManager,
        Suite $suite,
        JsonResponseHelper $jsonResponseHelper)
    {
        $id = 1;
        $jsonContent = '{\n "name":"Suite A, version 2"\n}';
        $data = [
            'name' => 'Suite A, version 2',
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

        $jsonResponseHelper
            ->okResponse($suite)
            ->shouldBeCalledTimes(1);

        $this
            ->updateAllProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_update_selected_action(
        Request $request,
        JsonHelper $jsonHelper,
        SuiteManager $suiteManager,
        Suite $suite,
        JsonResponseHelper $jsonResponseHelper)
    {
        $id = 1;
        $jsonContent = '{\n "name":"Suite A, version 2"\n}';
        $data = [
            'name' => 'Suite A, version 2',
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

        $jsonResponseHelper
            ->okResponse($suite)
            ->shouldBeCalledTimes(1);

        $this
            ->updateSelectedProperties($request, $id)
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_should_respond_to_delete_action(
        SuiteManager $suiteManager,
        JsonResponseHelper $jsonResponseHelper)
    {
        $suiteManager
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
