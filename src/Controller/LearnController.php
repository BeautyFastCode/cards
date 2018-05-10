<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LearnController
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
     * @Route("/learn/{card}/{state}", name="learn", defaults={"card"=0,"state"="question"})
     *
     * @param string $card
     * @param string $state
     *
     * @return Response
     */
    public function index(string $card, string $state)
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
                'card' => $card,
                'state' => $state,
            ]);
    }

    /**
     * @Route("/learn-summary", name="learn-summary")
     */
    public function learnSummary()
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
                'deck'  => $deck,
            ]);
    }
}
