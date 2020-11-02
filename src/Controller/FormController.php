<?php

namespace App\Controller;


use App\Entity\Film;
use App\Form\FilmType;
use App\Form\SearchMoviesByDirectorType;
use App\Repository\FilmRepository;
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

    // Rechercher les films par réalisateur
    /**
     * @Route("/form/read", name="read")
     */
    public function read(Request $request, FilmRepository $filmRepository)
    {
        $films = []; // Initialisation du tableau contenant la liste des films
        $form = $this->createForm(SearchMoviesByDirectorType::class); // Création du formulaire avec notre classe de formulaire
        $form->handleRequest($request); // Obligatoire : gestion de la requête

        if($form->isSubmitted() && $form->isValid())
        {
            $criteria = $form->getData(); // Critères de recherche en provenance du formulaire
            $films = $filmRepository->findBy($criteria, ['titre' => 'ASC']); // résultat
        }

        return $this->render('forms/read.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'form' => $form->createView(), // Envoi du formulaire à la vue
            'films' => $films, // Envoi du résultat du formulaire à la vue
        ]);
    }

    // Mettre un jour un film (listing)
    /**
     * @Route("/form/update", name="update")
     */
    public function update(Request $request, FilmRepository $filmRepository)
    {
        // Récupération de la liste de tous les films
        $films = $filmRepository->findby([], ['titre' => 'ASC']);

        return $this->render('forms/update.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'films' => $films,
        ]);
    }

    // Supprimer un film (listing)
    /**
     * @Route("/form/delete", name="delete")
     */
    public function delete(Request $request, FilmRepository $filmRepository)
    {
        // Récupération de la liste de tous les films
        $films = $filmRepository->findby([], ['titre' => 'ASC']);

        return $this->render('forms/delete.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'films' => $films,
        ]);
    }

    // Ajouter un film + Éditer un film
    /**
     * @Route("/form/create", name="create")
     * @Route("/edit/{id}", name="edit")
     */
    public function createAndEdit(Film $film = null, Request $request, EntityManagerInterface $entityManager)
    {
        if ($film !== null)
        {
            $noticeMessage = 'Votre film a bien été édité !';
            $route = 'update';
            $view = 'forms/edit.html.twig';
        } else {
            $noticeMessage = 'Votre film a bien été ajouté ! Il ne vous reste plus qu\'à trouver une page où vous pourrez voir le résultat ;-)';
            $route = 'create';
            $view = 'forms/create.html.twig';
        }

        $form = $this->createForm(FilmType::class, $film); // Création du formulaire

        $form->handleRequest($request); // Gestion de la requête

        if($form->isSubmitted() && $form->isValid())
        {
            $film = $form->getData();

            $entityManager->persist($film);
            $entityManager->flush();

            $this->addFlash('notice', $noticeMessage);

            return $this->redirectToRoute($route);
        }

        return $this->render($view, [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'form' => $form->createView(), // Envoi du formulaire à la vue
        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Film $film, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($film);
        $entityManager->flush();

        $this->addFlash
        (
            'notice',
            'Votre film a bien été supprimé !'
        );

        return $this->redirectToRoute('delete');
    }
}