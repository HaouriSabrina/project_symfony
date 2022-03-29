<?php

namespace App\Controller; // tous les namespace qui ne commencent pas par "APP" sont dans le vendor

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; //crée un alias pour la class pour faciliter le chemin pour retrouver la class
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')] //quand on veut créer une nouvelle route  on utilisera cette méthode (#)
    // pour créer un nouvel affichage c'est une nouvelle route 
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'bonjour',
            'texte' => 'le texte que je veux afficher'
        ]);
    }

    /* Exercices : 
    Ajouter une route pour le chemin "/test/calcul" qui utilise le fichier test/index.html.twig et qui affiche le résultat de 12+7
    */

    #[Route('/test/calcul', name:'test_calcul')]
    public function calcul(): Response
    {
        return $this->render('test/index.html.twig',[
            'controller_name' => 'Sabrina',
            'texte' => 'Hello',
            'calcul' => 12 + 7
        ]);
    }

    #[Route('/test/salut')]
    public function salut()
    {
        return $this->render("test/salut.html.twig", ["prenom" => "Sabrina"]);
    }

    #[Route('/test/tableau')]
    public function tableau()
    {
        $tableau = ["bonjour", "je m'apelle", 789, true];
        return $this->render("test/tableau.html.twig", [
            "tableau" => $tableau
        ]);
    }

    #[Route('/test/tableau-assoc')]

    public function tab()
    {
        $p = [
            "nom" => "Cérien",
            "prenom" => "Jean",
            "age" => 32
        ];

        return $this->render("test/assoc.html.twig", ["personne" => $p]);
        //Afficher "Je m'appelle" suivi du prénom et du nom dans le tableau
    }

    #[Route("test/objet")]

    public function objet()
    {
        $objet = new \stdClass;
        $objet->prenom = "Nordine";
        $objet->nom = "Ateur";
        $objet->age = 40;
        return $this->render("test/assoc.html.twig", ["personne" => $objet]);
    }
}
