<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController
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
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->templating->renderResponse('homepage/index.html.twig');
    }

    /**
     * @Route("/theme-showcase", name="theme-showcase")
     */
    public function themeShowcase()
    {
        return $this->templating->renderResponse('homepage/theme-showcase.html.twig');
    }
}
