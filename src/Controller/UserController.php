<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    /**
     * @var EngineInterface
     */
    private $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->templating->renderResponse('user/login.html.twig');
    }

    /**
     * @Route("/logged-out", name="logged-out")
     */
    public function loggedOut()
    {
        return $this->templating->renderResponse('user/logged-out.html.twig');
    }

    /**
     * @Route("/sign-up", name="sign-up")
     */
    public function signUp()
    {
        return $this->templating->renderResponse('user/sign-up.html.twig');
    }

    /**
     * @Route("/forgot", name="forgot")
     *
     * @param Request $request
     * @return Response
     */
    public function forgot(Request $request)
    {
        return $this->templating->renderResponse('user/forgot.html.twig',
            [
                'email' => $request->query->get('email'),
            ]);
    }

    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacy()
    {
        return $this->templating->renderResponse('user/sign-up.html.twig');
    }

    /**
     * @Route("/successfully-created", name="successfully-created")
     */
    public function successfullyCreated()
    {
        return $this->templating->renderResponse('user/successfully-created.html.twig');
    }
}
