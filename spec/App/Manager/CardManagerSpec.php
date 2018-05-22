<?php

namespace spec\App\Manager;

use App\Manager\BaseEntityManagerInterface;
use App\Manager\CardManager;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;

class CardManagerSpec extends ObjectBehavior
{
    function let(
        CardRepository $cardRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->beConstructedWith(
            $cardRepository,
            $entityManager
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CardManager::class);
    }

    function it_have_base_interface()
    {
        $this->shouldImplement(BaseEntityManagerInterface::class);
    }
}
