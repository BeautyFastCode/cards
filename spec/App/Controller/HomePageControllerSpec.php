<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Controller;

use App\Controller\HomePageController;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Specification for HomePageController.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class HomePageControllerSpec extends ObjectBehavior
{
    function let(EngineInterface $templating)
    {
        $this->beConstructedWith($templating);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HomePageController::class);
    }

    function it_should_respond_to_index_action(
        EngineInterface $templating,
        Response $response)
    {
        $templating
            ->renderResponse('homepage/index.html.twig')
            ->willReturn($response);

        $this
            ->index()
            ->shouldHaveType(Response::class);
    }

    function it_should_respond_to_theme_showcase_action(
        EngineInterface $templating,
        Response $response)
    {
        $templating
            ->renderResponse('homepage/theme-showcase.html.twig')
            ->willReturn($response);

        $this
            ->themeShowcase()
            ->shouldHaveType(Response::class);
    }
}
