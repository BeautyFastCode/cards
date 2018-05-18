<?php

namespace spec\App\Helper;

use App\Helper\JsonResponseHelper;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonResponseHelperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JsonResponseHelper::class);
    }

    function it_can_create_not_found_json_response()
    {
        $this
            ->notFoundResponse('')
            ->shouldHaveType(JsonResponse::class);
    }

    function it_can_create_not_found_json_response_2()
    {
        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this
            ->notFoundResponse('Not Found Response');

        $jsonResponse
            ->getStatusCode()
            ->shouldReturn(404);
    }

    function it_can_create_not_found_json_response_3()
    {
        /** @var JsonResponse $jsonResponse */
        $jsonResponse = $this
            ->notFoundResponse('Not Found Response');

        $jsonResponse
            ->getContent()
            ->shouldReturn('{"status":"error","errors":"Not Found Response"}');
    }
}
