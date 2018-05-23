<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for the home page.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class HomePageController
{
    /**
     * Templating engine renders a view and returns a Response.
     *
     * @var EngineInterface
     */
    private $templating;

    /**
     * Class constructor
     *
     * @param EngineInterface $templating Templating engine renders a view and returns a Response
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    /**
     * The main page for this website.
     *
     * @Route("/", name="homepage")
     *
     * @return Response A Response instance
     */
    public function index(): Response
    {
        return $this->templating->renderResponse('homepage/index.html.twig');
    }

    /**
     * Bootstrap theme showcase page.
     *
     * @Route("/theme-showcase", name="theme-showcase")
     *
     * @return Response A Response instance
     */
    public function themeShowcase(): Response
    {
        return $this->templating->renderResponse('homepage/theme-showcase.html.twig');
    }
}
