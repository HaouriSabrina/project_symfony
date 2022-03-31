<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\UserRepository;
use App\Repository\PlayerRepository;
use App\Repository\ContestRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController // Un controller est une classe. 
//Il y a un controller par thématique pour découper le projet.
{
    #[Route('/', name: 'app_home')]
    public function index(GameRepository $gameRepository, PlayerRepository $pr, UserRepository $userRepository): Response //Index est une action (le fait d'afficher la page), c'est aussi une fonction et une méthode. J'aurais pu l'appeler n'importe comment.
    {
        return $this->render('home/index.html.twig', [ //$this classe courante, ici HomeController
            'controller_name' => 'HomeController',
            'games' => $gameRepository->findAll(),
            'players' => count($pr->findAll()),
            'winners' => $pr->findWinners()
        ]);
    }
}
