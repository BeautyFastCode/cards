<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use App\Repository\CardRepository;

/**
 * CardManager
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class CardManager extends BaseEntityManager
{
    /**
     * @var CardRepository
     */
    private $cardRepository;

    /**
     * Class constructor
     *
     * @param CardRepository $cardRepository
     */
    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;

        parent::__construct($cardRepository);
    }
}
