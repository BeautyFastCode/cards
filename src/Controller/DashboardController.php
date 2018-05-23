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
 * Controller for Dashboard.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class DashboardController
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
     * The main dashboard page.
     *
     * @Route("/dashboard", name="dashboard")
     *
     * @return Response A Response instance
     */
    public function index(): Response
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

        return $this->templating->renderResponse('dashboard/index.html.twig',
            [
                'suites' => $suites,
            ]);
    }

    /**
     * Show one Deck.
     *
     * @Route("/deck", name="show-deck")
     *
     * @return Response A Response instance
     */
    public function showDeck(): Response
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

        return $this->templating->renderResponse('dashboard/show-deck.html.twig',
            [
                'deck' => $deck,
            ]);
    }

    /**
     * The main page for the JSON Api client - JavaScript and Vue.js
     *
     * @Route("/client", name="vue-dashboard")
     *
     * @return Response A Response instance
     */
    public function clientTest(): Response
    {
        return $this->templating->renderResponse('client/index.html.twig');
    }
}
