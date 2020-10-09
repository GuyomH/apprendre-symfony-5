<?php

namespace App\Controller;


use App\Entity\Film;
use App\Form\FilmType;
use App\Service\NavManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    private $pageList;
    private $routeList;

    public function __construct(NavManager $nav)
    {
        $this->pageList = $nav->pageList;
        $this->routeList = $nav->routeList;
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Film $film, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(FilmType::class, $film); // Création du formulaire avec les données du film courant

        $form->handleRequest($request); // Gestion de la requête

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();

            $this->addFlash
            (
                'notice',
                'Votre film a bien été édité !'
            );

            return $this->redirectToRoute('form3');
        }

        return $this->render('forms/edit.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'form3' => $form->createView(), // Envoi du formulaire à la vue
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Film $film, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($film);
        $entityManager->flush();

        $this->addFlash
        (
            'notice',
            'Votre film a bien été supprimé !'
        );

        return $this->redirectToRoute('form4');
    }
}