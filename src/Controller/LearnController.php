<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LearnController extends Controller
{
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

        return $this->render('learn/index.html.twig',
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

        return $this->render('learn/summary.html.twig',
            [
                'deck'  => $deck,
            ]);
    }
}
