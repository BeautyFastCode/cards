<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Manager;

use App\Entity\Traits\BaseInterface;
use App\Exception\EntityNotFoundException;
use App\Manager\BaseEntityManagerInterface;
use App\Manager\Stubs\BaseEntityManagerStub;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;

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
        EntityManagerInterface $entityManager)
    {
        $this->beAnInstanceOf(BaseEntityManagerStub::class);

        $this->beConstructedWith(
            $entityRepository,
            $entityManager
        );
    }

    function it_have_base_interface()
    {
        $this->shouldImplement(BaseEntityManagerInterface::class);
    }

    function it_can_read_an_entity(
        ObjectRepository $entityRepository,
        BaseInterface $entity)
    {
        $entityRepository
            ->findOneBy(['id' => 1])
            ->willReturn($entity);

        $this
            ->read(1)
            ->shouldReturn($entity);
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

    function it_can_delete_an_entity(
        EntityManagerInterface $entityManager,
        ObjectRepository $entityRepository,
        BaseInterface $entity)
    {

        $entityRepository
            ->findOneBy(['id' => 1])
            ->willReturn($entity);

        $entityManager
            ->remove($entity)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $this->delete(1);
    }
}
