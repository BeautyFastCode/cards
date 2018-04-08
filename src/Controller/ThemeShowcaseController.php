<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ThemeShowcaseController extends Controller
{
    /**
     * @Route("/theme/showcase", name="theme_showcase")
     */
    public function index()
    {
        return $this->render('theme_showcase/index.html.twig');
    }
}
