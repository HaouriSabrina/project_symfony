<?php

namespace App\Controller\Admin;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Game;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;

class GameController extends AbstractController
{
    #[Route('/admin/game', name: 'app_admin_game')]
    public function index(GameRepository $gameRepository): Response
    {
        //On ne peut pas instancier d'objet d'une classe Repository
        //On doit les passer dans les arguments d'une méthode d'un controleur
        //NB : Pour chaque classe entity créée, il y a une classe Repository qui correspond et qui permet de faire des requêtes SELECT sur la table correspondante. 
        // $gameRepository = new GameRepository;
        return $this->render('admin/game/index.html.twig', [
            'games' => $gameRepository->findAll()
        ]);
    }

    #[Route('/admin/game/new', name: 'app_admin_game_new')]
    /*
    *La classe request permet d'instancier un objet qui contient toutes les valeurs des variables super-globales de PHP. Ces valeurs sont des propriétés (qui sont des objets). 
    *$request->query      contient     $_GET
    *$request->request    contient     $_POST
    *$request->server     contient     $SERVER
    *Pour accéder aux valeurs on utilisera sur ces propriétés la méthode ->get('indice')
    *La classe EntityManager va permettre d'éxécuter les requêtes qui modifient les données (INSERT, UPDATE, DELETE).
    *L'EntityManager va toujours utiliser des objets Entity pour modifier les données. 
    */
    public function new(Request $request, EntityManagerInterface $em)
    {
        $jeu = new Game;
        /* On crée un objet $form pour gérer le formulaire. Il est crée à partir de la classe GameType. On relie ce formulaire à l'objet $jeu */
        $form =$this->createForm(GameType::class, $jeu);
        /* L'objet $form va gérer ce qui vient de la requête HTTP (avec l'objet $request)*/
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            //La méthode persist() prépare la requête INSERT avec les données de l'objet passé en argument. 
            $em->persist($jeu);

            //La méthode flush() éxécute les requêtes en attente et donc modifie la BDD
            $em->flush();

            //redirection 
            return $this->redirectToRoute("app_admin_game");
        }
        return $this->render("admin/game/form.html.twig", [
            "formGame" => $form->createView()
        ]);
    }

    #[Route('/admin/game/edit/{id}', name: 'app_admin_game_edit')]

    public function edit(Request $rq, EntityManagerInterface $em, GameRepository $gameRepository, $id)
    {
        $jeu = $gameRepository->find($id);
        $form = $this->createForm(GameType::class, $jeu);
        $form->handleRequest($rq);
        if( $form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute("app_admin_game");
        }
        return $this->render("admin/game/form.html.twig", [
            "formGame" => $form->createView()
        ]);
    }

    #[Route('/admin/game/modifier/{title}', name: 'app_admin_game_modifier')]
    // Si le chemin de la route contient une partie variable (donc entre{}), on peut récupérer un objet entité directement avec la valeur de cette partie de l'URL. Il faut que le nom de ce paramètre soit le nom d'une propriété de la classe Entity. Par exemple, le paramètre est {title}, parce que dans l'entité Game il y a une propriété title. Dans les arguments de la méthode, on peut alors utiliser un objet de la classe Game($jeu dans l'exemple)

    public function modifier(Request $rq, EntityManagerInterface $em, Game $jeu)
    {
        // $jeu = $gameRepository->find($id);
        $form = $this->createForm(GameType::class, $jeu);
        $form->handleRequest($rq);
        if( $form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute("app_admin_game");
        }
        return $this->render("admin/game/form.html.twig", [
            "formGame" => $form->createView()
        ]);
    }

    #[Route('/admin/game/delete/{id}', name: 'app_admin_game_delete')]

    public function delete($id, GameRepository $gr, Request $rq, EntityManagerInterface $em)
    {
        $jeu = $gr->find($id);
        if( $rq->isMethod("POST")){
            $em->remove($jeu);
            $em->flush();
            return $this->redirectToRoute("app_admin_game");
        }
        
        return $this->render("admin/game/delete.html.twig",["game" => $jeu]);
    }
}