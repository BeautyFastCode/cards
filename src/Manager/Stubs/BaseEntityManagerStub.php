<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Manager\Stubs;

use App\Entity\Stubs\BaseEntityStub;
use App\Manager\BaseEntityManager;
use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * BaseEntityManagerStub
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class BaseEntityManagerStub extends BaseEntityManager
{
    protected function getEntity()
    {
        return new BaseEntityStub();
    }

    protected function getEntityFormType()
    {
        return FormType::class;
    }

    protected function getEntityClassName(): string
    {
        return BaseEntityStub::class;
    }
}
