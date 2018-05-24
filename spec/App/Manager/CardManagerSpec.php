<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Manager;

use App\Entity\Card;
use App\Exception\EntityNotFoundException;
use App\Form\CardType;
use App\Helper\FormHelper;
use App\Manager\BaseEntityManagerInterface;
use App\Manager\CardManager;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;

/**
 * Specification for CardManager.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class CardManagerSpec extends ObjectBehavior
{
    public function let(
        CardRepository $cardRepository,
        EntityManagerInterface $entityManager,
        FormHelper $formHelper)
    {
        $this->beConstructedWith(
            $cardRepository,
            $entityManager,
            $formHelper);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CardManager::class);
    }

    public function it_have_base_interface()
    {
        $this->shouldImplement(BaseEntityManagerInterface::class);
    }

    public function it_can_trow_exception_when_not_find_card(CardRepository $cardRepository)
    {
        $cardRepository
            ->findOneBy(['id' => 1000])
            ->willReturn(null);

        $this
            ->shouldThrow(EntityNotFoundException::class)
            ->duringRead(1000);
    }

    public function it_can_create_card(
        EntityManagerInterface $entityManager,
        FormHelper $formHelper,
        Card $card,
        CardRepository $cardRepository)
    {
        $data = [
            'question' => 'Where are you?',
            'answer' => 'I\'m here.',
            'deck' => 1,
        ];

        $formHelper
            ->submitEntity(CardType::class, new Card(), $data)
            ->willReturn($card);

        $entityManager
            ->persist($card)
            ->shouldBeCalledTimes(1);

        $entityManager
            ->flush()
            ->shouldBeCalledTimes(1);

        $card
            ->getId()
            ->willReturn(1);

        $cardRepository
            ->findOneBy(['id' => 1])
            ->willReturn($card);

        $this
            ->create($data);
    }
}
