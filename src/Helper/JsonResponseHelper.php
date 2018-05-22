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
     * todo: add another response, check usage new JsonResponse
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
}
