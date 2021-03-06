<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Manager;

use App\Entity\BaseEntity;
use App\Entity\Card;
use App\Form\CardType;
use App\Helper\FormHelper;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Manager - base CRUD functionality for the card entity.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class CardManager extends BaseEntityManager
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        CardRepository $cardRepository,
        EntityManagerInterface $entityManager,
        FormHelper $formHelper
    ) {
        parent::__construct($cardRepository, $entityManager, $formHelper);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntity(): BaseEntity
    {
        return new Card();
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClassName(): string
    {
        return Card::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityFormTypeClassName(): string
    {
        return CardType::class;
    }
}
