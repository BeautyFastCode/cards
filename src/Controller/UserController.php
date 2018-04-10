<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('user/login.html.twig');
    }

    /**
     * @Route("/logged-out", name="logged-out")
     */
    public function loggedOut()
    {
        return $this->render('user/logged-out.html.twig');
    }

    /**
     * @Route("/sign-up", name="sign-up")
     */
    public function signUp()
    {
        return $this->render('user/sign-up.html.twig');
    }

    /**
     * @Route("/forgot", name="forgot")
     */
    public function forgot()
    {
        return $this->render('user/forgot.html.twig');
    }

    /**
     * @Route("/privacy", name="privacy")
     */
    public function privacy()
    {
        return $this->render('user/sign-up.html.twig');
    }
}
