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
use App\Manager\SuiteManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * JSON Api for the Suite entity:
 * todo: Create BaseApiController for Api.
 *
 * api_suites_get_item               GET      ANY      ANY    /api/suites/{id}
 * api_suites_get_collection         GET      ANY      ANY    /api/suites
 * api_suites_post_item              POST     ANY      ANY    /api/suites
 * api_suites_put_item               PUT      ANY      ANY    /api/suites/{id}
 * api_suites_patch_item             PATCH    ANY      ANY    /api/suites/{id}
 * api_suites_delete_item            DELETE   ANY      ANY    /api/suites/{id}
 *
 * @Route("/api/suites")
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class SuiteController
{
    /**
     * Manager for the Suite entity.
     *
     * @var SuiteManager
     */
    private $suiteManager;

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
     * @param SuiteManager       $suiteManager       Manager for the Suite entity
     * @param JsonHelper         $jsonHelper         Helper decodes a JSON string to an associative array
     * @param JsonResponseHelper $jsonResponseHelper Helper to generate JSON responses
     */
    public function __construct(
        SuiteManager $suiteManager,
        JsonHelper $jsonHelper,
        JsonResponseHelper $jsonResponseHelper
    ) {
        $this->suiteManager = $suiteManager;
        $this->jsonHelper = $jsonHelper;
        $this->jsonResponseHelper = $jsonResponseHelper;
    }

    /**
     * Read action - get one Suite.
     *
     * @Route("/{id}", name="api_suites_get_item", requirements={"id"="\d+"})
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
            ->okResponse($this->suiteManager->read($id));
    }

    /**
     * List action - list of all the Suites.
     *
     * @Route("", name="api_suites_get_collection")
     * @Method({"GET"})
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function list(): JsonResponse
    {
        return $this
            ->jsonResponseHelper
            ->okResponse($this->suiteManager->list());
    }

    /**
     * Create action - create on Suite.
     *
     * @Route("", name="api_suites_post_item")
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
     * Update action - update all properties in the Suite.
     *
     * @Route("/{id}", name="api_suites_put_item", requirements={"id"="\d+"})
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
     * Update action - update selected properties in the Suite.
     *
     * @Route("/{id}", name="api_suites_patch_item", requirements={"id"="\d+"})
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
     * Handles requests for update or create a Suite.
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
             * Update an existing Suite.
             */
            if ($allProperties) {
                $responseData = $this->suiteManager->update($id, $data);
            } else {
                $responseData = $this->suiteManager->update($id, $data, false);
            }

            return $this
                ->jsonResponseHelper
                ->okResponse($responseData);
        } else {
            /*
             * Create the new Suite.
             */
            $responseData = $this->suiteManager->create($data);

            return $this
                ->jsonResponseHelper
                ->createdResponse($responseData);
        }
    }

    /**
     * Delete action - delete one Suite.
     *
     * @Route("/{id}", name="api_suites_delete_item", requirements={"id"="\d+"})
     * @Method({"DELETE"})
     *
     * @param int $id
     *
     * @return JsonResponse A JsonResponse instance
     */
    public function delete(int $id): JsonResponse
    {
        $this->suiteManager->delete($id);

        return $this
            ->jsonResponseHelper
            ->noContentResponse();
    }
}
