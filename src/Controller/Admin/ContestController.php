<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Entity\Contest;
use App\Form\ContestType;
use App\Repository\GameRepository;
use App\Repository\ContestRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/contest")
 */
class ContestController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_contest_index", methods={"GET"})
     */
    public function index(ContestRepository $contestRepository): Response
    {
        return $this->render('admin/contest/index.html.twig', [
            'contests' => $contestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_contest_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ContestRepository $contestRepository): Response
    {
        $contest = new Contest();
        $form = $this->createForm(ContestType::class, $contest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contestRepository->add($contest);
            return $this->redirectToRoute('app_admin_contest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/contest/new.html.twig', [
            'contest' => $contest,
            'form' => $form,
        ]);
    }

    #[Route('/new/{id}', name:'app_admin_new_game_contest', methods:['GET','POST'])]
    public function newGameContest(Request $request, Game $game, ContestRepository $contestRepository): Response
    {
        $contest = new Contest();
        $contest->setGame($game);
        $form = $this->createForm(ContestType::class, $contest);
        $form->handleRequest($request); //Permet d'alimenter le formulaire avec des données de la request.
        

        if ($form->isSubmitted() && $form->isValid()) {
            $contestRepository->add($contest);
            return $this->redirectToRoute('app_admin_contest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/contest/new.html.twig', [
            'contest' => $contest,
            'form' => $form,
        ]);

    }

    /**
     * @Route("/{id}", name="app_admin_contest_show", methods={"GET"})
     */
    public function show(Contest $contest): Response
    {
        return $this->render('admin/contest/show.html.twig', [
            'contest' => $contest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_contest_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Contest $contest, ContestRepository $contestRepository): Response
    {
        $form = $this->createForm(ContestType::class, $contest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contestRepository->add($contest);
            return $this->redirectToRoute('app_admin_contest_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/contest/edit.html.twig', [
            'contest' => $contest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_contest_delete", methods={"POST"})
     */
    public function delete(Request $request, Contest $contest, ContestRepository $contestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contest->getId(), $request->request->get('_token'))) {
            $contestRepository->remove($contest);
        }

        return $this->redirectToRoute('app_admin_contest_index', [], Response::HTTP_SEE_OTHER);
    }
}
