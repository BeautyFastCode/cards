<?php

namespace spec\App\Controller\Api;

use App\Controller\Api\SuiteController;
use App\Entity\Deck;
use App\Entity\Suite;
use App\Repository\SuiteRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class SuiteControllerSpec extends ObjectBehavior
{
    function let(
        EntityManagerInterface $entityManager,
        FormErrorSerializer $formErrorSerializer,
        SuiteRepository $suiteRepository,
        FormFactoryInterface $formFactory
    )
    {
        $this->beConstructedWith(
            $entityManager,
            $formErrorSerializer,
            $suiteRepository,
            $formFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SuiteController::class);
    }

    function it_should_respond_to_read_action(Suite $suite)
    {
        $suite->jsonSerialize()->willReturn([]);

        $this
            ->read($suite)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_list_action(SuiteRepository $suiteRepository)
    {
        $suiteRepository->findAll()->willReturn([]);

        $this
            ->list()
            ->shouldHaveType(JsonResponse::class);
    }

//    function it_should_respond_to_create_action(
//        Request $request,
//        FormFactory $formFactory,
//        FormInterface $form
//    )
//    {
//        $data = [];
//
//        $request->getContent()->shouldBeCalledTimes(1);
//
//        $formFactory
//            ->create(SuiteType::class, new Suite())
//            ->willReturn($form);
//
//        $form->submit($data)->shouldBeCalledTimes(1);
//        $form->getData()->shouldBeCalledTimes(1);
//
//        $this
//            ->create($request)
//            ->shouldHaveType(JsonResponse::class);
//    }

    function it_should_respond_to_delete_action(
        Suite $suite,
        EntityManagerInterface $entityManager
    )
    {
        $suite->getDecks()->willReturn(new ArrayCollection());

        $entityManager->remove($suite)->shouldBeCalledTimes(1);
        $entityManager->flush()->shouldBeCalledTimes(2);

        $this
            ->delete($suite)
            ->shouldHaveType(JsonResponse::class);
    }

    function it_should_respond_to_delete_action_2(
        Suite $suite,
        EntityManagerInterface $entityManager
    )
    {
        // Prepare data
        $deck = new Deck();
        $decks = new ArrayCollection();
        $decks->add($deck);

        // Promise
        $suite->getDecks()->willReturn($decks);

        // Expectations
        $suite->removeDeck($deck)->shouldBeCalledTimes(1);

        $entityManager->remove($suite)->shouldBeCalledTimes(1);
        $entityManager->flush()->shouldBeCalledTimes(2);

        // Delete
        $this
            ->delete($suite)
            ->shouldHaveType(JsonResponse::class);
    }
}
