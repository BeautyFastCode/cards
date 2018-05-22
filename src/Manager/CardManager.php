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
use Doctrine\ORM\EntityManagerInterface;

/**
 * CardManager
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class CardManager extends BaseEntityManager
{
    /**
     * Class constructor
     *
     * @param CardRepository         $cardRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CardRepository $cardRepository,
                                EntityManagerInterface $entityManager)
    {
        parent::__construct($cardRepository, $entityManager);
    }
}
