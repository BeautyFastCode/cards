<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for user functionality.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class UserController
{
    /**
     * Templating engine renders a view and returns a Response.
     *
     * @var EngineInterface
     */
    private $templating;

    /**
     * Class constructor.
     *
     * @param EngineInterface $templating Templating engine renders a view and returns a Response
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * An User login.
     *
     * @Route("/login", name="login")
     *
     * @return Response A Response instance
     */
    public function login(): Response
    {
        return $this->templating->renderResponse('user/login.html.twig');
    }

    /**
     * An User logged out.
     *
     * @Route("/logged-out", name="logged-out")
     *
     * @return Response A Response instance
     */
    public function loggedOut(): Response
    {
        return $this->templating->renderResponse('user/logged-out.html.twig');
    }

    /**
     * An User sing up.
     *
     * @Route("/sign-up", name="sign-up")
     *
     * @return Response A Response instance
     */
    public function signUp(): Response
    {
        return $this->templating->renderResponse('user/sign-up.html.twig');
    }

    /**
     * An User forgot password.
     *
     * @Route("/forgot", name="forgot")
     *
     * @param Request $request
     *
     * @return Response A Response instance
     */
    public function forgot(Request $request): Response
    {
        return $this->templating->renderResponse(
            'user/forgot.html.twig',
            [
                'email' => $request->query->get('email'),
            ]
        );
    }

    /**
     * The privacy policy page.
     *
     * @Route("/privacy", name="privacy")
     *
     * @return Response A Response instance
     */
    public function privacy(): Response
    {
        return $this->templating->renderResponse('user/sign-up.html.twig');
    }

    /**
     * An User was successfully created.
     *
     * @Route("/successfully-created", name="successfully-created")
     *
     * @return Response A Response instance
     */
    public function successfullyCreated(): Response
    {
        return $this->templating->renderResponse('user/successfully-created.html.twig');
    }
}
