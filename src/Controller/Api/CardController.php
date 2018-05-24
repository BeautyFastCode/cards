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
use App\Manager\CardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * JSON Api for the Card entity.
 *
 * api_cards_get_item               GET      ANY      ANY    /api/cards/{id}
 * api_cards_get_collection         GET      ANY      ANY    /api/cards
 * api_cards_post_item              POST     ANY      ANY    /api/cards
 * api_cards_put_item               PUT      ANY      ANY    /api/cards/{id}
 * api_cards_patch_item             PATCH    ANY      ANY    /api/cards/{id}
 * api_cards_delete_item            DELETE   ANY      ANY    /api/cards/{id}
 *
 * @Route("/api/cards")
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class CardController
{
    /**
     * Manager for the Card entity.
     *
     * @var CardManager
     */
    private $cardManager;

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
     * @param CardManager        $cardManager        Manager for the Card entity
     * @param JsonHelper         $jsonHelper         Helper decodes a JSON string to an associative array
     * @param JsonResponseHelper $jsonResponseHelper Helper to generate JSON responses
     */
    public function __construct(
        CardManager $cardManager,
        JsonHelper $jsonHelper,
        JsonResponseHelper $jsonResponseHelper
    ) {
        $this->cardManager = $cardManager;
        $this->jsonHelper = $jsonHelper;
        $this->jsonResponseHelper = $jsonResponseHelper;
    }

    /**
     * Read action - get one Card.
     *
     * @Route("/{id}", name="api_cards_get_item", requirements={"id"="\d+"})
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
            ->okResponse($this->cardManager->read($id));
    }

    /**
     * List action - list of all the Cards.
     *
     * @Route("", name="api_cards_get_collection")
     * @Method({"GET"})
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function list(): JsonResponse
    {
        return $this
            ->jsonResponseHelper
            ->okResponse($this->cardManager->list());
    }

    /**
     * Create action - create one Card.
     *
     * @Route("", name="api_cards_post_item")
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
     * Update action - update all properties in the Card.
     *
     * @Route("/{id}", name="api_cards_put_item", requirements={"id"="\d+"})
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
     * Update action - update selected properties in the Card.
     *
     * @Route("/{id}", name="api_cards_patch_item", requirements={"id"="\d+"})
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
     * Handles requests for update or create a Card.
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
     * Delete action - delete one Card.
     *
     * @Route("/{id}", name="api_cards_delete_item", requirements={"id"="\d+"})
     * @Method({"DELETE"})
     *
     * @param int $id
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function delete(int $id): JsonResponse
    {
        $this->cardManager->delete($id);

        return $this
            ->jsonResponseHelper
            ->noContentResponse();
    }
}
