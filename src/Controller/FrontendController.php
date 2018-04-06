<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
    /**
     * @Route("/", name="frontend")
     */
    public function index()
    {
        return $this->render('frontend/index.html.twig');
    }
}
