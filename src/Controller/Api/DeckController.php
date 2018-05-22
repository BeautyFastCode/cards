<?php

namespace App\Controller\Api;

use App\Helper\JsonHelper;
use App\Helper\JsonResponseHelper;
use App\Manager\DeckManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
class DeckController
{
    /**
     * @var DeckManager
     */
    private $deckManager;

    /**
     * @var JsonHelper
     */
    private $jsonHelper;

    /**
     * @var JsonResponseHelper
     */
    private $jsonResponseHelper;

    /**
     * Class constructor
     *
     * @param DeckManager        $deckManager
     * @param JsonHelper         $jsonHelper
     * @param JsonResponseHelper $jsonResponseHelper
     */
    public function __construct(DeckManager $deckManager,
                                JsonHelper $jsonHelper,
                                JsonResponseHelper $jsonResponseHelper)
    {

        $this->deckManager = $deckManager;
        $this->jsonHelper = $jsonHelper;
        $this->jsonResponseHelper = $jsonResponseHelper;
    }

    /**
     * Read action
     *
     * @Route("/api/decks/{id}", name="api_decks_get_item", requirements={"id"="\d+"})
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        return $this
            ->jsonResponseHelper
            ->okResponse($this->deckManager->read($id));
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
        return $this
            ->jsonResponseHelper
            ->okResponse($this->deckManager->list());
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
        return $this->update($request);
    }

    /**
     * Update all properties action
     *
     * @Route("/api/decks/{id}", name="api_decks_put_item", requirements={"id"="\d+"})
     * @Method({"PUT"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function updateAllProperties(Request $request, int $id):JsonResponse
    {
        return $this->update($request, $id);
    }

    /**
     * Update selected properties action
     *
     * @Route("/api/decks/{id}", name="api_decks_patch_item", requirements={"id"="\d+"})
     * @Method({"PATCH"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     */
    public function updateSelectedProperties(Request $request, int $id):JsonResponse
    {
        return $this->update($request, $id, false);
    }

    /**
     * @param Request $request
     * @param int     $id
     * @param bool    $allProperties
     *
     * @return JsonResponse
     */
    private function update(Request $request, int $id = null, bool $allProperties = true):JsonResponse
    {
        /*
         * Get data from request.
         */
        $data = $this
            ->jsonHelper
            ->decode($request->getContent());

        if ($id !== null) {
            /*
             * Update an existing Deck.
             */
            if ($allProperties) {
                $responseData = $this->deckManager->update($id, $data);
            } else {
                $responseData = $this->deckManager->update($id, $data, false);
            }

            return $this
                ->jsonResponseHelper
                ->okResponse($responseData);

        } else {
            /*
             * Create the new Deck.
             */
            $responseData = $this->deckManager->create($data);

            return $this
                ->jsonResponseHelper
                ->createdResponse($responseData);
        }
    }

    /**
     * Delete action
     *
     * @Route("/api/decks/{id}", name="api_decks_delete_item", requirements={"id"="\d+"})
     * @Method({"DELETE"})
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->deckManager->delete($id);

        return $this
            ->jsonResponseHelper
            ->noContentResponse();
    }
}
