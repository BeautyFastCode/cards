<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Manager;

use App\Entity\Deck;
use App\Entity\Suite;
use App\Exception\EntityNotFoundException;
use App\Form\SuiteType;
use App\Helper\FormHelper;
use App\Manager\SuiteManager;
use App\Repository\SuiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;

/**
 * Specification for SuiteManager.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class SuiteManagerSpec extends ObjectBehavior
{
    public function let(
        SuiteRepository $suiteRepository,
        EntityManagerInterface $entityManager,
        FormHelper $formHelper)
    {
        $this->beConstructedWith(
            $suiteRepository,
            $entityManager,
            $formHelper);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SuiteManager::class);
    }

    public function it_can_read_one_suite(
        SuiteRepository $suiteRepository,
        Suite $suite)
    {
        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $this
            ->read(1)
            ->shouldReturn($suite);
    }

    public function it_can_trow_exception_when_not_find_suite(SuiteRepository $suiteRepository)
    {
        $suiteRepository
            ->findOneBy(['id' => 1000])
            ->willReturn(null);

        $this
            ->shouldThrow(EntityNotFoundException::class)
            ->duringRead(1000);
    }

    public function it_can_find_all_suites(SuiteRepository $suiteRepository)
    {
        $suiteRepository
            ->findAll()
            ->willReturn([]);

        $this
            ->list()
            ->shouldBeArray();
    }

    public function it_can_create_suite(
        EntityManagerInterface $entityManager,
        FormHelper $formHelper,
        Suite $suite,
        SuiteRepository $suiteRepository)
    {
        $data = ['name' => 'New Suite'];

        $formHelper
            ->submitEntity(SuiteType::class, new Suite(), $data)
            ->willReturn($suite);

        $entityManager
            ->persist($suite)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $suite
            ->getId()
            ->willReturn(1);

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $this
            ->create($data);
    }

    public function it_can_update_properties_in_the_suite(
        SuiteRepository $suiteRepository,
        FormHelper $formHelper,
        Suite $suite,
        EntityManagerInterface $entityManager)
    {
        $id = 1;
        $data = ['name' => 'Suite A, version 2'];

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $formHelper
            ->submitEntity(SuiteType::class, $suite, $data, true)
            ->willReturn($suite);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $suite
            ->getId()
            ->willReturn(1);

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $this
            ->update($id, $data);
    }

    public function it_can_delete_suite(
        EntityManagerInterface $entityManager,
        SuiteRepository $suiteRepository,
        Suite $suite)
    {
        $deck = new Deck();
        $decks = new ArrayCollection();
        $decks->add($deck);

        $suiteRepository
            ->findOneBy(['id' => 1])
            ->willReturn($suite);

        $suite
            ->getDecks()
            ->willReturn($decks);

        $suite
            ->removeDeck($deck)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->remove($suite)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(2);

        $this->delete(1);
    }

    public function it_can_get_form_errors(FormHelper $formHelper)
    {
        $formHelper
            ->getErrors()
            ->willReturn([]);

        $this
            ->getErrors()
            ->shouldBeArray();
    }
}
