<?php

namespace spec\App\Controller;

use App\Controller\UserController;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerSpec extends ObjectBehavior
{
    function let(EngineInterface $templating)
    {
        $this->beConstructedWith($templating);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserController::class);
    }

    function it_should_respond_to_login_action(EngineInterface $templating, Response $response)
    {
        $templating
            ->renderResponse('user/login.html.twig')
            ->willReturn($response);

        $this
            ->login()
            ->shouldHaveType(Response::class);
    }

    function it_should_respond_to_logged_out_action(EngineInterface $templating, Response $response)
    {
        $templating
            ->renderResponse('user/logged-out.html.twig')
            ->willReturn($response);

        $this
            ->loggedOut()
            ->shouldHaveType(Response::class);
    }

    function it_should_respond_to_sign_up_action(EngineInterface $templating, Response $response)
    {
        $templating
            ->renderResponse('user/sign-up.html.twig')
            ->willReturn($response);

        $this
            ->signUp()
            ->shouldHaveType(Response::class);
    }

    function it_should_respond_to_forgot_action(
        EngineInterface $templating,
        Response $response,
        Request $request,
        ParameterBag $query
    )
    {
        $request->query = $query;
        $query->get('email')
            ->willReturn('test@mail.com');

        $templating
            ->renderResponse('user/forgot.html.twig',
                [
                    'email' => $request->query->get('email'),
                ])
            ->willReturn($response);

        $this
            ->forgot($request)
            ->shouldHaveType(Response::class);
    }

    function it_should_respond_to_privacy_action(EngineInterface $templating, Response $response)
    {
        $templating
            ->renderResponse('user/sign-up.html.twig')
            ->willReturn($response);

        $this
            ->privacy()
            ->shouldHaveType(Response::class);
    }

    function it_should_respond_to_successfully_created_action(EngineInterface $templating, Response $response)
    {
        $templating
            ->renderResponse('user/successfully-created.html.twig')
            ->willReturn($response);

        $this
            ->successfullyCreated()
            ->shouldHaveType(Response::class);
    }
}
