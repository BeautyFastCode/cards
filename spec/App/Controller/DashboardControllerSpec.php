<?php

namespace spec\App\Controller;

use App\Controller\DashboardController;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

class DashboardControllerSpec extends ObjectBehavior
{
    function let(EngineInterface $templating)
    {
        $this->beConstructedWith($templating);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DashboardController::class);
    }

    function it_should_respond_to_index_action(EngineInterface $templating, Response $response)
    {
        $suites = [
            [
                'name'  => 'Suite A',
                'decks' => [
                    [
                        'name'       => 'Untitled Deck',
                        'background' => 'bg-secondary',
                    ],
                    [
                        'name'       => 'Welcome Deck',
                        'background' => 'bg-success',
                    ],
                    [
                        'name'       => 'Information Deck',
                        'background' => 'bg-info',
                    ],
                ],
            ],
            [
                'name'  => 'Calendar',
                'decks' => [
                    [
                        'name'       => '2018 - 04',
                        'background' => 'bg-danger',
                    ],
                    [
                        'name'       => 'Project Cards',
                        'background' => 'bg-warning',
                    ],
                ],
            ],
            ['name' => 'Empty Suite'],
        ];

        $templating
            ->renderResponse('dashboard/index.html.twig', ['suites' => $suites])
            ->willReturn($response);

        $this
            ->index()
            ->shouldHaveType(Response::class);
    }

    function it_should_respond_to_show_deck_action(EngineInterface $templating, Response $response)
    {
        $deck = [
            'name'       => 'Welcome Deck',
            'background' => 'bg-success',
            'cards'      => [
                [
                    'front' => 'Front Card',
                    'back'  => 'Back Card',
                ],
                [
                    'front' => 'How are you?',
                    'back'  => 'I\'m fine.',
                ],
                [
                    'front' => 'What colour do you like?',
                    'back'  => 'I like the red cherry.',
                ],
            ],
        ];

        $templating
            ->renderResponse('dashboard/show-deck.html.twig', ['deck' => $deck])
            ->willReturn($response);

        $this
            ->showDeck()
            ->shouldHaveType(Response::class);
    }

    function it_should_respond_to_vue_test_action(EngineInterface $templating, Response $response)
    {
        $templating
            ->renderResponse('vue/index.html.twig')
            ->willReturn($response);

        $this
            ->vueTest()
            ->shouldHaveType(Response::class);
    }
}
