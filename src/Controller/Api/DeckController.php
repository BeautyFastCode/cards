<?php

namespace App\Controller\Api;

use App\Entity\Deck;
use App\Form\DeckType;
use App\Repository\DeckRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    
    /**
     * Create action
     *
     * @Route("/api/decks", name="api_decks_post_item")
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

        $form = $this->createForm(DeckType::class, new Deck());
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

        $deck = $form->getData();

        $this->entityManager->persist($deck);
        $this->entityManager->flush();

        return new JsonResponse(
            $deck,
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Update all properties action
     *
     * @Route("/api/decks/{id}", name="api_decks_put_item", requirements={"id"="\d+"})
     * @Method({"PUT"})
     *
     * @param Request $request
     * @param Deck    $deck
     *
     * @return JsonResponse
     */
    public function updateAllProperties(Request $request, Deck $deck):JsonResponse
    {

        $data = json_decode(
            $request->getContent(),
            true
        );

        $form = $this->createForm(DeckType::class, $deck);
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

        $deck = $form->getData();

        $this->entityManager->flush();

        return new JsonResponse(
            $deck,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Update selected properties action
     *
     * @Route("/api/decks/{id}", name="api_decks_patch_item", requirements={"id"="\d+"})
     * @Method({"PATCH"})
     *
     * @param Request $request
     * @param Deck   $deck
     *
     * @return JsonResponse
     */
    public function updateSelectedProperties(Request $request, Deck $deck):JsonResponse
    {

        $data = json_decode(
            $request->getContent(),
            true
        );

        $form = $this->createForm(DeckType::class, $deck);
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

        $deck = $form->getData();

        $this->entityManager->flush();

        return new JsonResponse(
            $deck,
            JsonResponse::HTTP_OK
        );
    }
  
    /**
     * Delete action
     *
     * @Route("/api/decks/{id}", name="api_decks_delete_item", requirements={"id"="\d+"})
     * @Method({"DELETE"})
     *
     * @param Deck $deck
     *
     * @return JsonResponse
     */
    public function delete(Deck $deck): JsonResponse
    {
        /*
         * Delete only relationship to Suite (join table), not Suite.
         */
        foreach ($deck->getSuites() as $suite) {
            $deck->removeSuite($suite);
        }
        $this->entityManager->flush();

        /*
         * Delete Deck.
         */
        $this->entityManager->remove($deck);
        $this->entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }    
}
