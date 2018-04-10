<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomePageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('homepage/index.html.twig');
    }

    /**
     * @Route("/theme-showcase", name="theme-showcase")
     */
    public function themeShowcase()
    {
        return $this->render('homepage/theme-showcase.html.twig');
    }
}
