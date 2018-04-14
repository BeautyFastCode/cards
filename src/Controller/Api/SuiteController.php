<?php

namespace App\Controller\Api;

use App\Entity\Suite;
use App\Form\SuiteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
  api_suites_get_collection         GET      ANY      ANY    /api/suites
  api_suites_post_collection        POST     ANY      ANY    /api/suites
  api_suites_get_item               GET      ANY      ANY    /api/suites/{id}
  api_suites_put_item               PUT      ANY      ANY    /api/suites/{id}
  api_suites_delete_item            DELETE   ANY      ANY    /api/suites/{id}
 */

class SuiteController extends Controller
{
    /**
     * Read action
     *
     * @Route("/api/suites/{id}", name="api_suites_get_item")
     * @Method({"GET"})
     *
     * @param Suite $suite
     *
     * @return JsonResponse
     */
    public function read(Suite $suite): JsonResponse
    {
        return new JsonResponse(
            $suite->asArray(),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Collection of all the Suites
     *
     * @Route("/api/suites", name="api_suites_get_collection")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $suites = $this->getDoctrine()
            ->getRepository(Suite::class)
            ->findAll();

        $suitesArray = [];
        foreach ($suites as $suite) {
            /** @var Suite $suite */
            $suitesArray[] = $suite->asArray();
        }

        return new JsonResponse(
            $suitesArray,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Create action
     *
     * @Route("/api/suites", name="api_suites_post_collection")
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

        $form = $this->createForm(SuiteType::class, new Suite());
        $form->submit($data);

        if (false === $form->isValid()) {
            return new JsonResponse(
                [
                    'status' => 'Form is not valid',
                ]
            );
        }

        $suite = $form->getData();

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($suite);
        $manager->flush();

        return new JsonResponse(
            $suite->asArray(),
            JsonResponse::HTTP_CREATED
        );
    }
}
