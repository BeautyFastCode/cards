<?php

namespace App\Controller;

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
}
