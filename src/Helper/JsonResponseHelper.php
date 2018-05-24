<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Helper to generate JSON responses.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class JsonResponseHelper
{
    /**
     * Returns HTTP_OK a JSON response.
     *
     * @param mixed $data (optional) The response data
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function okResponse($data = null): JsonResponse
    {
        return new JsonResponse(
            $data,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Returns HTTP_CREATED a JSON response.
     *
     * @param mixed $data (optional) The response data
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function createdResponse($data = null): JsonResponse
    {
        return new JsonResponse(
            $data,
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Returns HTTP_NO_CONTENT a JSON response.
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function noContentResponse(): JsonResponse
    {
        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }

    /**
     * Returns HTTP_NOT_FOUND a JSON response.
     *
     * @param string $message The message
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function notFoundResponse(string $message): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'error',
                'message' => $message,
            ],
            JsonResponse::HTTP_NOT_FOUND
        );
    }

    /**
     * Returns HTTP_BAD_REQUEST a JSON response.
     *
     * @param string $message The message
     * @param array  $data    (optional) An errors
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function badRequestResponse(string $message, array $data = null): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'error',
                'message' => $message,
                'errors' => $data,
            ],
            JsonResponse::HTTP_BAD_REQUEST
        );
    }
}
