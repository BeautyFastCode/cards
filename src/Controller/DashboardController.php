<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
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

        return $this->render('dashboard/index.html.twig', ['suites' => $suites]);
    }

    /**
     * @Route("/deck/{card}/{state}", name="show-deck", defaults={"card"=0,"state"="question"})
     *
     * @param string $card
     * @param string $state
     *
     * @return Response
     */
    public function showDeck(string $card, string $state)
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

        return $this->render('dashboard/show-deck.html.twig',
            [
                'deck'  => $deck,
                'card' => $card,
                'state' => $state,
            ]);
    }
}
