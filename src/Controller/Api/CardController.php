<?php

namespace App\Controller\Api;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * JSON Api for Card entity:
 *
 * api_cards_get_item               GET      ANY      ANY    /api/cards/{id}
 * api_cards_get_collection         GET      ANY      ANY    /api/cards
 * api_cards_post_item              POST     ANY      ANY    /api/cards
 * api_cards_put_item               PUT      ANY      ANY    /api/cards/{id}
 * api_cards_patch_item             PATCH    ANY      ANY    /api/cards/{id}
 * api_cards_delete_item            DELETE   ANY      ANY    /api/cards/{id}
 */
class CardController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FormErrorSerializer
     */
    private $formErrorSerializer;

    /**
     * @var CardRepository
     */
    private $cardRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * Class constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param FormErrorSerializer    $formErrorSerializer
     * @param CardRepository         $cardRepository
     * @param FormFactoryInterface   $formFactory
     */
    public function __construct(EntityManagerInterface $entityManager,
                                FormErrorSerializer $formErrorSerializer,
                                CardRepository $cardRepository,
                                FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formErrorSerializer = $formErrorSerializer;
        $this->cardRepository = $cardRepository;
        $this->formFactory = $formFactory;
    }

    /**
     * Read action
     *
     * @Route("/api/cards/{id}", name="api_cards_get_item", requirements={"id"="\d+"})
     * @Method({"GET"})
     *
     * @param Card $card
     *
     * @return JsonResponse
     */
    public function read(Card $card): JsonResponse
    {
        return new JsonResponse(
            $card,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Collection of all the Cards
     *
     * @Route("/api/cards", name="api_cards_get_collection")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return new JsonResponse(
            $this->cardRepository->findAll(),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Create action
     *
     * @Route("/api/cards", name="api_cards_post_item")
     * @Method({"Post"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $form = $this->formFactory->create(CardType::class, new Card());
        $form->submit($data);

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'errors' => $this->formErrorSerializer
                        ->convertFormToArray($form),
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $card = $form->getData();

        $this->entityManager->persist($card);
        $this->entityManager->flush();

        return new JsonResponse(
            $card,
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Update all properties action
     *
     * @Route("/api/cards/{id}", name="api_cards_put_item", requirements={"id"="\d+"})
     * @Method({"PUT"})
     *
     * @param Request $request
     * @param Card    $card
     *
     * @return JsonResponse
     */
    public function updateAllProperties(Request $request, Card $card):JsonResponse
    {

        $data = json_decode(
            $request->getContent(),
            true
        );

        $form = $this->formFactory->create(CardType::class, $card);
        $form->submit($data);

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'errors' => $this->formErrorSerializer
                        ->convertFormToArray($form),
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $card = $form->getData();

        $this->entityManager->flush();

        return new JsonResponse(
            $card,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Update selected properties action
     *
     * @Route("/api/cards/{id}", name="api_cards_patch_item", requirements={"id"="\d+"})
     * @Method({"PATCH"})
     *
     * @param Request $request
     * @param Card    $card
     *
     * @return JsonResponse
     */
    public function updateSelectedProperties(Request $request, Card $card):JsonResponse
    {

        $data = json_decode(
            $request->getContent(),
            true
        );

        $form = $this->formFactory->create(CardType::class, $card);
        $form->submit($data, false);

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'errors' => $this->formErrorSerializer
                        ->convertFormToArray($form),
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $card = $form->getData();

        $this->entityManager->flush();

        return new JsonResponse(
            $card,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Delete action
     *
     * @Route("/api/cards/{id}", name="api_cards_delete_item", requirements={"id"="\d+"})
     * @Method({"DELETE"})
     *
     * @param Card $card
     *
     * @return JsonResponse
     */
    public function delete(Card $card): JsonResponse
    {
        $this->entityManager->remove($card);
        $this->entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
