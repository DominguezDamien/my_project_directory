<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecetteController extends AbstractController
{
    #[Route('/recette', name: 'recette.index', methods: ['GET'])]
    public function index(RecetteRepository $repository): Response
    {
        $recettes = $repository -> findAll();

        return $this->render('pages/recette/index.html.twig', [
            'recettes' => $recettes,
        ]);
    }


    #[Route('/recette/nouveau', name: 'recette.new', methods: ['GET'])]
    public function new (Request $request): Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class,$recette);
        $form->handleRequest($request);


        return $this->render('pages/recette/new.html.twig',[
            'form' => $form -> createView()
        ]);
    }

    #[Route('/recette/{id}', name: 'recette.edit', methods: ['GET','POST'])]
    public function edit (Request $request): Response

    {
        return $this->render('pages/recette/new.html.twig',[
        ]);
    }


}
