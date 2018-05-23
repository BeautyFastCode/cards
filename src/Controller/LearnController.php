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
 * Controller for the learning pages.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class LearnController
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
     * The page for the learning session.
     *
     * @Route("/learn/{card}/{state}", name="learn", defaults={"card"=0,"state"="question"})
     *
     * @param string $card  The current card in learning process
     * @param string $state The current learning state
     *
     * @return Response A Response instance
     */
    public function index(string $card, string $state): Response
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

        return $this->templating->renderResponse('learn/index.html.twig',
            [
                'deck'  => $deck,
                'card'  => $card,
                'state' => $state,
            ]);
    }

    /**
     * The summary of learning session.
     *
     * @Route("/learn-summary", name="learn-summary")
     *
     * @return Response A Response instance
     */
    public function learnSummary(): Response
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

        return $this->templating->renderResponse('learn/summary.html.twig',
            [
                'deck' => $deck,
            ]);
    }
}
