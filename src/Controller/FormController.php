<?php

namespace App\Controller;


use App\Entity\Film;
use App\Form\FilmType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    // TODO: Logique à déplacer dans un service
    private $pageList = [
        'Accueil' => 'index',
        'Contrôleur' => 'controller',
        'Twig' => 'twig',
        'Base de données' => 'db',
        'Formulaires' => [
            'Lire des données' => 'form1',
            'Ajouter des données' => 'form2',
            'Mettre à jour des données' => 'form3',
            'Supprimer des données' => 'form4',
        ],
        'Service' => 'service',
        'Authentification' => 'auth',
        'Références' => 'references',
    ];

    private $pathList = [];

    public function __construct()
    {
        foreach($this->pageList as $menuTitle => $pathName)
        {
            if(is_array($pathName))
            {
                foreach($pathName as $menuTitle2 => $pathName2)
                {

                    $this->pathList[] = [$pathName2, $menuTitle2];
                }
            } else {
                $this->pathList[] = [$pathName, $menuTitle];
            }
        }
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
            'path_list' => $this->pathList,
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