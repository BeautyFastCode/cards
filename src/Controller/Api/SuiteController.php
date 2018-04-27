<?php

namespace App\Controller\Api;

use App\Entity\Suite;
use App\Form\SuiteType;
use App\Repository\SuiteRepository;
use App\Serializer\FormErrorSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
 */
class SuiteController extends AbstractController
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
     * @var SuiteRepository
     */
    private $suiteRepository;

    /**
     * Class constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param FormErrorSerializer    $formErrorSerializer
     * @param SuiteRepository        $suiteRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
                                FormErrorSerializer $formErrorSerializer,
                                SuiteRepository $suiteRepository)
    {
        $this->entityManager = $entityManager;
        $this->formErrorSerializer = $formErrorSerializer;
        $this->suiteRepository = $suiteRepository;
    }

    /**
     * Read action
     *
     * @Route("/api/suites/{id}", name="api_suites_get_item", requirements={"id"="\d+"})
     * @Method({"GET"})
     *
     * @param Suite $suite
     *
     * @return JsonResponse
     */
    public function read(Suite $suite): JsonResponse
    {
        return new JsonResponse(
            $suite,
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
        return new JsonResponse(
            $this->suiteRepository->findAll(),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Create action
     *
     * @Route("/api/suites", name="api_suites_post_item")
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
                    'status' => 'error',
                    'errors' => $this->formErrorSerializer
                        ->convertFormToArray($form),
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $suite = $form->getData();

        $this->entityManager->persist($suite);
        $this->entityManager->flush();

        return new JsonResponse(
            $suite,
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * Update all properties action
     *
     * @Route("/api/suites/{id}", name="api_suites_put_item", requirements={"id"="\d+"})
     * @Method({"PUT"})
     *
     * @param Request $request
     * @param Suite   $suite
     *
     * @return JsonResponse
     */
    public function updateAllProperties(Request $request, Suite $suite):JsonResponse
    {

        $data = json_decode(
            $request->getContent(),
            true
        );

        $form = $this->createForm(SuiteType::class, $suite);
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

        $suite = $form->getData();

        $this->entityManager->flush();

        return new JsonResponse(
            $suite,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Update selected properties action
     *
     * @Route("/api/suites/{id}", name="api_suites_patch_item", requirements={"id"="\d+"})
     * @Method({"PATCH"})
     *
     * @param Request $request
     * @param Suite   $suite
     *
     * @return JsonResponse
     */
    public function updateSelectedProperties(Request $request, Suite $suite):JsonResponse
    {

        $data = json_decode(
            $request->getContent(),
            true
        );

        $form = $this->createForm(SuiteType::class, $suite);
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

        $suite = $form->getData();

        $this->entityManager->flush();

        /*
         * todo: in response select $suite from Repository, in ALL controllers
         */

        return new JsonResponse(
            $suite,
            JsonResponse::HTTP_OK
        );
    }

    /**
     * Delete action
     *
     * @Route("/api/suites/{id}", name="api_suites_delete_item", requirements={"id"="\d+"})
     * @Method({"DELETE"})
     *
     * @param Suite $suite
     *
     * @return JsonResponse
     */
    public function delete(Suite $suite): JsonResponse
    {
        /*
         * Delete only relationship to Deck (join table), not Deck.
         */
        foreach ($suite->getDecks() as $deck) {
            $suite->removeDeck($deck);
        }
        $this->entityManager->flush();

        /*
         * Delete Suite.
         */
        $this->entityManager->remove($suite);
        $this->entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}
