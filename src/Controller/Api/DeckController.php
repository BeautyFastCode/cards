<?php

namespace App\Controller\Api;

use App\Entity\Deck;
use App\Repository\DeckRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * JSON Api for Deck entity:
 *
 * api_decks_get_item               GET      ANY      ANY    /api/decks/{id}
 * api_decks_get_collection         GET      ANY      ANY    /api/decks
 * api_decks_post_item              POST     ANY      ANY    /api/decks
 * api_decks_put_item               PUT      ANY      ANY    /api/decks/{id}
 * api_decks_patch_item             PATCH    ANY      ANY    /api/decks/{id}
 * api_decks_delete_item            DELETE   ANY      ANY    /api/decks/{id}
 */
class DeckController extends AbstractController
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
     * @var DeckRepository
     */
    private $deckRepository;

    /**
     * Class constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param FormErrorSerializer    $formErrorSerializer
     * @param DeckRepository        $deckRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
                                FormErrorSerializer $formErrorSerializer,
                                DeckRepository $deckRepository)
    {
        $this->entityManager = $entityManager;
        $this->formErrorSerializer = $formErrorSerializer;
        $this->deckRepository = $deckRepository;
    }

    /**
     * Read action
     *
     * @Route("/api/decks/{id}", name="api_decks_get_item", requirements={"id"="\d+"})
     * @Method({"GET"})
     *
     * @param Deck $deck
     *
     * @return JsonResponse
     */
    public function read(Deck $deck): JsonResponse
    {
        return new JsonResponse(
            $deck,
            JsonResponse::HTTP_OK
        );
    }
    
    /**
     * Collection of all the Decks
     *
     * @Route("/api/decks", name="api_decks_get_collection")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return new JsonResponse(
            $this->deckRepository->findAll(),
            JsonResponse::HTTP_OK
        );
    }
}
