<?php

declare(strict_types=1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\App\Controller;

use App\Controller\LearnController;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Specification for LearnController.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class LearnControllerSpec extends ObjectBehavior
{
    public function let(EngineInterface $templating)
    {
        $this->beConstructedWith($templating);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(LearnController::class);
    }

    public function it_should_respond_to_index_action(
        EngineInterface $templating,
        Response $response)
    {
        $deck = [
            'name' => 'Welcome Deck',
            'background' => 'bg-success',
            'cards' => [
                [
                    'front' => 'Front Card',
                    'back' => 'Back Card',
                ],
                [
                    'front' => 'How are you?',
                    'back' => 'I\'m fine.',
                ],
                [
                    'front' => 'What colour do you like?',
                    'back' => 'I like the red cherry.',
                ],
            ],
        ];
        $card = 0;
        $state = 'question';

        $templating
            ->renderResponse('learn/index.html.twig',
                [
                    'deck' => $deck,
                    'card' => $card,
                    'state' => $state,
                ])
            ->willReturn($response);

        $this
            ->index($card, $state)
            ->shouldHaveType(Response::class);
    }

    public function it_should_respond_to_learn_summary_action(
        EngineInterface $templating,
        Response $response)
    {
        $deck = [
            'name' => 'Welcome Deck',
            'background' => 'bg-success',
            'cards' => [
                [
                    'front' => 'Front Card',
                    'back' => 'Back Card',
                ],
                [
                    'front' => 'How are you?',
                    'back' => 'I\'m fine.',
                ],
                [
                    'front' => 'What colour do you like?',
                    'back' => 'I like the red cherry.',
                ],
            ],
        ];

        $templating
            ->renderResponse('learn/summary.html.twig', ['deck' => $deck])
            ->willReturn($response);

        $this
            ->learnSummary()
            ->shouldHaveType(Response::class);
    }
}
