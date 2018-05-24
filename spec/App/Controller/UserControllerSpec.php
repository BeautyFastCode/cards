<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Controller;

use App\Controller\UserController;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Specification for UserController.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class UserControllerSpec extends ObjectBehavior
{
    public function let(EngineInterface $templating)
    {
        $this->beConstructedWith($templating);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(UserController::class);
    }

    public function it_should_respond_to_login_action(
        EngineInterface $templating,
        Response $response)
    {
        $templating
            ->renderResponse('user/login.html.twig')
            ->willReturn($response);

        $this
            ->login()
            ->shouldHaveType(Response::class);
    }

    public function it_should_respond_to_logged_out_action(
        EngineInterface $templating,
        Response $response)
    {
        $templating
            ->renderResponse('user/logged-out.html.twig')
            ->willReturn($response);

        $this
            ->loggedOut()
            ->shouldHaveType(Response::class);
    }

    public function it_should_respond_to_sign_up_action(
        EngineInterface $templating,
        Response $response)
    {
        $templating
            ->renderResponse('user/sign-up.html.twig')
            ->willReturn($response);

        $this
            ->signUp()
            ->shouldHaveType(Response::class);
    }

    public function it_should_respond_to_forgot_action(
        EngineInterface $templating,
        Response $response,
        Request $request,
        ParameterBag $query)
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

    public function it_should_respond_to_privacy_action(
        EngineInterface $templating,
        Response $response)
    {
        $templating
            ->renderResponse('user/sign-up.html.twig')
            ->willReturn($response);

        $this
            ->privacy()
            ->shouldHaveType(Response::class);
    }

    public function it_should_respond_to_successfully_created_action(
        EngineInterface $templating,
        Response $response)
    {
        $templating
            ->renderResponse('user/successfully-created.html.twig')
            ->willReturn($response);

        $this
            ->successfullyCreated()
            ->shouldHaveType(Response::class);
    }
}
