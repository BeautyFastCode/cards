<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Entity\Suite;
use App\Manager\SuiteManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * JSON Api for Suite entity:
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
class SuiteNewController
{
    /**
     * @var SuiteManager
     */
    private $suiteManager;

    /**
     * Class constructor
     *
     * @param SuiteManager $suiteManager
     */
    public function __construct(SuiteManager $suiteManager)
    {
        $this->suiteManager = $suiteManager;
    }

    /**
     * Read action
     *
     * @Route("/{id}", name="api_suites_get_item", requirements={"id"="\d+"})
     * @Method({"GET"})
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        return new JsonResponse(
            $this->suiteManager->read($id),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * List of all the Suites
     *
     * @Route("", name="api_suites_get_collection")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return new JsonResponse(
            $this->suiteManager->list(),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Create action
     *
     * @Route("", name="api_suites_post_item")
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
     * @Route("/{id}", name="api_suites_put_item", requirements={"id"="\d+"})
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
     * @Route("/{id}", name="api_suites_patch_item", requirements={"id"="\d+"})
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
     * Delete action
     *
     * @Route("/{id}", name="api_suites_delete_item", requirements={"id"="\d+"})
     * @Method({"DELETE"})
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->suiteManager->delete($id);

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
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
        $data = json_decode(
            $request->getContent(),
            true
        );

        if ($id !== null) {
            /*
             * Update an existing Suite.
             */
            if ($allProperties) {
                $responseData = $this->suiteManager->update($id, $data);
            } else {
                $responseData = $this->suiteManager->update($id, $data, false);
            }
            $responseStatus = JsonResponse::HTTP_OK;

        } else {
            /*
             * Create the new Suite.
             */
            $responseData = $this->suiteManager->create($data);
            $responseStatus = JsonResponse::HTTP_CREATED;
        }

        /*
         * Failed update or create the Suite.
         */
        if (!($responseData instanceof Suite)) {
            $responseData = [
                'status' => 'error',
                'errors' => $this->suiteManager->getErrors(),
            ];
            $responseStatus = JsonResponse::HTTP_BAD_REQUEST;
        }

        /*
         * Response
         */

        return new JsonResponse(
            $responseData,
            $responseStatus
        );
    }
}