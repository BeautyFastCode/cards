<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Helper\JsonHelper;
use App\Helper\JsonResponseHelper;
use App\Manager\DeckManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * JSON Api for the Deck entity.
 *
 * api_decks_get_item               GET      ANY      ANY    /api/decks/{id}
 * api_decks_get_collection         GET      ANY      ANY    /api/decks
 * api_decks_post_item              POST     ANY      ANY    /api/decks
 * api_decks_put_item               PUT      ANY      ANY    /api/decks/{id}
 * api_decks_patch_item             PATCH    ANY      ANY    /api/decks/{id}
 * api_decks_delete_item            DELETE   ANY      ANY    /api/decks/{id}
 *
 * @Route("/api/decks")
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class DeckController
{
    /**
     * Manager for the Deck entity.
     *
     * @var DeckManager
     */
    private $deckManager;

    /**
     * Helper decodes a JSON string to an associative array.
     *
     * @var JsonHelper
     */
    private $jsonHelper;

    /**
     * Helper to generate JSON responses.
     *
     * @var JsonResponseHelper
     */
    private $jsonResponseHelper;

    /**
     * Class constructor.
     *
     * @param DeckManager        $deckManager        Manager for the Deck entity
     * @param JsonHelper         $jsonHelper         Helper decodes a JSON string to an associative array
     * @param JsonResponseHelper $jsonResponseHelper Helper to generate JSON responses
     */
    public function __construct(
        DeckManager $deckManager,
        JsonHelper $jsonHelper,
        JsonResponseHelper $jsonResponseHelper
    ) {
        $this->deckManager = $deckManager;
        $this->jsonHelper = $jsonHelper;
        $this->jsonResponseHelper = $jsonResponseHelper;
    }

    /**
     * Read action - get one Deck.
     *
     * @Route("/{id}", name="api_decks_get_item", requirements={"id"="\d+"})
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function read(int $id): JsonResponse
    {
        return $this
            ->jsonResponseHelper
            ->okResponse($this->deckManager->read($id));
    }

    /**
     * List action - list of all the Decks.
     *
     * @Route("", name="api_decks_get_collection")
     * @Method({"GET"})
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function list(): JsonResponse
    {
        return $this
            ->jsonResponseHelper
            ->okResponse($this->deckManager->list());
    }

    /**
     * Create action - create one Deck.
     *
     * @Route("", name="api_decks_post_item")
     * @Method({"Post"})
     *
     * @param Request $request
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function create(Request $request): JsonResponse
    {
        return $this->update($request);
    }

    /**
     * Update action - update all properties in the Deck.
     *
     * @Route("/{id}", name="api_decks_put_item", requirements={"id"="\d+"})
     * @Method({"PUT"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function updateAllProperties(Request $request, int $id): JsonResponse
    {
        return $this->update($request, $id);
    }

    /**
     * Update action - update selected properties in the Deck.
     *
     * @Route("/{id}", name="api_decks_patch_item", requirements={"id"="\d+"})
     * @Method({"PATCH"})
     *
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function updateSelectedProperties(Request $request, int $id): JsonResponse
    {
        return $this->update($request, $id, false);
    }

    /**
     * Handles requests for update or create a Deck.
     *
     * @param Request $request
     * @param int     $id
     * @param bool    $allProperties
     *
     * @return JsonResponse A JsonResponse instance
     */
    private function update(Request $request, int $id = null, bool $allProperties = true): JsonResponse
    {
        /*
         * Get data from request.
         */
        $data = $this
            ->jsonHelper
            ->decode($request->getContent());

        if (null !== $id) {
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
     * Delete action - delete one Deck.
     *
     * @Route("/{id}", name="api_decks_delete_item", requirements={"id"="\d+"})
     * @Method({"DELETE"})
     *
     * @param int $id
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function delete(int $id): JsonResponse
    {
        $this->deckManager->delete($id);

        return $this
            ->jsonResponseHelper
            ->noContentResponse();
    }
}
