<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Helper;

/**
 * Helper decodes a JSON string to an associative array.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class JsonHelper
{
    /**
     * Decodes a JSON string to an associative array.
     *
     * @param string $json The json string being decoded
     *
     * @return array
     */
    public function decode(string $json): array
    {
        return json_decode($json, true);
    }
}
