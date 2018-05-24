<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Manager\Stubs;

use App\Entity\BaseEntity;
use App\Entity\Stubs\BaseEntityStub;
use App\Manager\BaseEntityManager;
use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * Stub for BaseEntity Manager used in specifications.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class BaseEntityManagerStub extends BaseEntityManager
{
    /**
     * {@inheritdoc}
     */
    protected function getEntity(): BaseEntity
    {
        return new BaseEntityStub();
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClassName(): string
    {
        return BaseEntityStub::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityFormTypeClassName(): string
    {
        return FormType::class;
    }
}
