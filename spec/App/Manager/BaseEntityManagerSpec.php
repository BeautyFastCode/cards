<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Manager;

use App\Entity\Stubs\BaseEntityStub;
use App\Entity\Traits\BaseEntityInterface;
use App\Exception\EntityNotFoundException;
use App\Helper\FormHelper;
use App\Manager\BaseEntityManagerInterface;
use App\Manager\Stubs\BaseEntityManagerStub;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * BaseEntityManagerSpec
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class BaseEntityManagerSpec extends ObjectBehavior
{
    function let(
        ObjectRepository $entityRepository,
        EntityManagerInterface $entityManager,
        FormHelper $formHelper)
    {
        $this->beAnInstanceOf(BaseEntityManagerStub::class);

        $this->beConstructedWith(
            $entityRepository,
            $entityManager,
            $formHelper
        );
    }

    function it_have_base_interface()
    {
        $this->shouldImplement(BaseEntityManagerInterface::class);
    }

    function it_can_read_an_entity(
        ObjectRepository $entityRepository,
        BaseEntityInterface $baseEntity)
    {
        $entityRepository
            ->findOneBy(['id' => 1])
            ->willReturn($baseEntity);

        $this
            ->read(1)
            ->shouldReturn($baseEntity);
    }

    function it_can_trow_exception_when_not_find_an_entity(
        ObjectRepository $entityRepository)
    {
        $entityRepository
            ->findOneBy(['id' => 1000])
            ->willReturn(null);

        $this
            ->shouldThrow(EntityNotFoundException::class)
            ->duringRead(1000);
    }

    function it_can_find_all_entities(ObjectRepository $entityRepository)
    {
        $entityRepository
            ->findAll()
            ->willReturn([]);;

        $this
            ->list()
            ->shouldBeArray();
    }

    function it_can_create_an_entity(
        EntityManagerInterface $entityManager,
        FormHelper $formHelper,
        BaseEntityInterface $baseEntity,
        ObjectRepository $entityRepository)
    {
        $data = [];

        $formHelper
            ->submitEntity(FormType::class, new BaseEntityStub(), $data)
            ->willReturn($baseEntity);

        $entityManager
            ->persist($baseEntity)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $baseEntity
            ->getId()
            ->willReturn(1);

        $entityRepository
            ->findOneBy(['id' => 1])
            ->willReturn($baseEntity);

        $this
            ->create($data);
    }

     function it_can_create_an_entity_2(FormHelper $formHelper)
    {
        $data = [];

        $formHelper
            ->submitEntity(FormType::class, new BaseEntityStub(), $data)
            ->willReturn(null);

        $this
            ->create($data);
    }

    function it_can_update_properties_in_an_entity(
        ObjectRepository $entityRepository,
        BaseEntityInterface $baseEntity,
        EntityManagerInterface $entityManager)
    {
        $id = 1;
        $data = [];

        $entityRepository
            ->findOneBy(['id' => 1])
            ->willReturn($baseEntity);

//        $formHelper
//            ->submitEntity(SuiteType::class, $suite, $data)
//            ->willReturn($suite);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $baseEntity
            ->getId()
            ->willReturn(1);

        $entityRepository
            ->findOneBy(['id' => 1])
            ->willReturn($baseEntity);

        $this
            ->update($id, $data);
    }

    function it_can_delete_an_entity(
        EntityManagerInterface $entityManager,
        ObjectRepository $entityRepository,
        BaseEntityInterface $baseEntity)
    {

        $entityRepository
            ->findOneBy(['id' => 1])
            ->willReturn($baseEntity);

        $entityManager
            ->remove($baseEntity)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $this->delete(1);
    }

    function it_can_get_form_errors(FormHelper $formHelper)
    {
        $formHelper
            ->getErrors()
            ->willReturn([]);

        $this
            ->getErrors()
            ->shouldBeArray();

    }
}
