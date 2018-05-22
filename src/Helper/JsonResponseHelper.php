<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helper;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * JsonResponseHelper
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class JsonResponseHelper
{
    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    public function notFoundResponse(string $message): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'error',
                'errors' => $message,
            ],
            JsonResponse::HTTP_NOT_FOUND
        );
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return JsonResponse
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

    /**
     * todo: check usage new JsonResponse
     *
     * @param array $data
     * @param int   $status
     *
     * @return JsonResponse
     */
    public function commonResponse(array $data, int $status): JsonResponse
    {
        return new JsonResponse(
            $data,
            $status
        );
    }
}
