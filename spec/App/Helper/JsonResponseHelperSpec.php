<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Helper;

use App\Helper\JsonResponseHelper;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Specification for JsonResponseHelper.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class JsonResponseHelperSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(JsonResponseHelper::class);
    }

    public function it_can_create_ok_json_response()
    {
        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this->okResponse();

        $jsonResponse
            ->getStatusCode()
            ->shouldReturn(200);
    }

    public function it_can_create_created_json_response()
    {
        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this->createdResponse();

        $jsonResponse
            ->getStatusCode()
            ->shouldReturn(201);
    }

    public function it_can_create_no_content_json_response()
    {
        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this->noContentResponse();

        $jsonResponse
            ->getStatusCode()
            ->shouldReturn(204);
    }

    public function it_can_create_not_found_json_response()
    {
        $this
            ->notFoundResponse('')
            ->shouldHaveType(JsonResponse::class);
    }

    public function it_can_create_not_found_json_response_2()
    {
        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this->notFoundResponse('Not Found Response');

        $jsonResponse
            ->getStatusCode()
            ->shouldReturn(404);
    }

    public function it_can_create_not_found_json_response_3()
    {
        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this->notFoundResponse('Not Found Response');

        $jsonResponse
            ->getContent()
            ->shouldReturn('{"status":"error","message":"Not Found Response"}');
    }

    public function it_can_create_bad_request_json_response()
    {
        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this->badRequestResponse('Bad Request Response');

        $jsonResponse
            ->getStatusCode()
            ->shouldReturn(400);

        $jsonResponse
            ->getContent()
            ->shouldReturn('{"status":"error","message":"Bad Request Response","errors":null}');
    }
}
