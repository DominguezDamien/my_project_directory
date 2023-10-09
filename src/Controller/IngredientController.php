<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient_index', methods: 'GET')]
    public function index(Request $request,IngredientRepository $repository, PaginatorInterface $paginator): Response
    {
        $ingredients = $repository -> findAll();

        $ingredients = $paginator->paginate(
            $repository -> findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }

    #[Route('/ingredient/nouveau','ingredient.new', methods: ['get','post'])]
    public function new(Request $request,
    EntityManagerInterface $manager) : Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class,$ingredient);

        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $ingredient = $form-> getData();

            $manager -> persist($ingredient);
            $manager -> flush();

            $this->addFlash(
                'success',
                'Votre ingrédient a été crée avec succès !'
            );

            return $this ->redirectToRoute('app_ingredient_index');
        }

        return $this -> render ('pages/ingredient/new.html.twig',[
            'form' => $form ->createView()
        ]);
    }

    #[Route('/ingredient/edition/{id}', 'ingredient.edit', methods: ['GET','POST'])]
    public function edit(Ingredient $ingredient, Request $request,EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(IngredientType::class,$ingredient);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $ingredient = $form-> getData();

            $manager -> persist($ingredient);
            $manager -> flush();

            $this->addFlash(
                'success',
                'Votre ingrédient a été modifié avec succès !'
            );

            return $this ->redirectToRoute('app_ingredient_index');
        }

        return $this ->render('pages/ingredient/edit.html.twig',[
            'form' =>$form->createView()
        ]);
    }

    #[Route('/ingredient/suppression/{id}','ingredient.suprimer', methods: ['GET'])]
    public function delete (EntityManagerInterface $manager, Ingredient $ingredient) :Response
    {
        $manager -> remove($ingredient);
        $manager -> flush();
        $this->addFlash(
            'success',
            'Votre ingrédient a été supprimé avec succès !'
        );
        return $this -> redirectToRoute ('app_ingredient_index');
    }



}
