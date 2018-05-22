<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use App\Entity\Traits\BaseInterface;

/**
 * Contact for BaseEntityManager
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
interface BaseEntityManagerInterface
{
    /**
     * @param int $id
     *
     * @return BaseInterface
     */
    public function read(int $id): BaseInterface;

    /**
     * @return array
     */
    public function list(): array;
}
