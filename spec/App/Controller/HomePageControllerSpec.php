<?php

namespace spec\App\Controller;

use App\Controller\HomePageController;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class HomePageControllerSpec extends ObjectBehavior
{
    function let(
        ContainerInterface $container,
        EngineInterface $templating
    )
    {
        $this->setContainer($container);

        $container
            ->has('templating')
            ->willReturn(true);

        $container
            ->get('templating')
            ->willReturn($templating);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HomePageController::class);
    }

    function it_should_respond_to_index_action()
    {
        $this
            ->index()
            ->shouldHaveType(Response::class);
    }

    function it_should_respond_to_theme_showcase_action()
    {
        $this
            ->themeShowcase()
            ->shouldHaveType(Response::class);
    }
}
