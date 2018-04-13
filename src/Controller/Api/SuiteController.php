<?php

namespace App\Controller\Api;

use App\Entity\Suite;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * List of all the Suites
     * 
     * @Route("/api/suites", name="api_suites_get_collection")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $suites = $this->getDoctrine()
            ->getRepository(Suite::class)
            ->findAll();

        $suitesArray = [];
        foreach ($suites as $suite) {
            /** @var Suite $suite */
            $suitesArray[] = $suite->asArray();
        }

        return new JsonResponse($suitesArray);
    }
}
