<?php

namespace App\Controller\Api;

use App\Helper\JsonHelper;
use App\Helper\JsonResponseHelper;
use App\Manager\CardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @var CardManager
     */
    private $cardManager;

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
     * @param CardManager        $cardManager
     * @param JsonHelper         $jsonHelper
     * @param JsonResponseHelper $jsonResponseHelper
     */
    public function __construct(CardManager $cardManager,
                                JsonHelper $jsonHelper,
                                JsonResponseHelper $jsonResponseHelper)
    {
        $this->cardManager = $cardManager;
        $this->jsonHelper = $jsonHelper;
        $this->jsonResponseHelper = $jsonResponseHelper;
    }

    /**
     * Read action
     *
     * @Route("/api/cards/{id}", name="api_cards_get_item", requirements={"id"="\d+"})
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
            ->okResponse($this->cardManager->read($id));
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
        return $this
            ->jsonResponseHelper
            ->okResponse($this->cardManager->list());
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
        return $this->update($request);
    }

    /**
     * Update all properties action
     *
     * @Route("/api/cards/{id}", name="api_cards_put_item", requirements={"id"="\d+"})
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
     * @Route("/api/cards/{id}", name="api_cards_patch_item", requirements={"id"="\d+"})
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
             * Update an existing Card.
             */
            if ($allProperties) {
                $responseData = $this->cardManager->update($id, $data);
            } else {
                $responseData = $this->cardManager->update($id, $data, false);
            }

            return $this
                ->jsonResponseHelper
                ->okResponse($responseData);

        } else {
            /*
             * Create the new Card.
             */
            $responseData = $this->cardManager->create($data);

            return $this
                ->jsonResponseHelper
                ->createdResponse($responseData);
        }
    }

    /**
     * Delete action
     *
     * @Route("/api/cards/{id}", name="api_cards_delete_item", requirements={"id"="\d+"})
     * @Method({"DELETE"})
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->cardManager->delete($id);

        return $this
            ->jsonResponseHelper
            ->noContentResponse();
    }
}
