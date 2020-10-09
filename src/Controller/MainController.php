<?php

namespace App\Controller;

use App\Form\FilmType;
use App\Form\SearchMoviesByDirectorType;
use App\Repository\FilmRepository;
use App\Service\NavManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $pageList;
    private $routeList;

    public function __construct(NavManager $nav)
    {
        $this->pageList = $nav->pageList;
        $this->routeList = $nav->routeList;
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }

    /**
     * @Route("/controller", name="controller")
     */
    public function controller()
    {
        return $this->render('main/controller.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }

    /**
     * @Route("/twig", name="twig")
     */
    public function twig()
    {
        return $this->render('main/twig.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }

    /**
     * @Route("/db", name="db")
     */
    public function db(FilmRepository $filmRepository)
    {
        $films = $filmRepository->findBy([], ['titre' => 'ASC']);

        return $this->render('main/db.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'films' => $films,
        ]);
    }

    // Rechercher les films par réalisateur
    /**
     * @Route("/form/read", name="form1")
     */
    public function form1(Request $request, FilmRepository $filmRepository)
    {
        $films = []; // Initialisation du tableau contenant la liste des films
        $form = $this->createForm(SearchMoviesByDirectorType::class); // Création du formulaire avec notre classe de formulaire
        $form->handleRequest($request); // Obligatoire : gestion de la requête

        if($form->isSubmitted() && $form->isValid())
        {
            $criteria = $form->getData(); // Critères de recherche en provenance du formulaire
            $films = $filmRepository->findBy($criteria, ['titre' => 'ASC']); // résultat
        }

        return $this->render('main/form1.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'form' => $form->createView(), // Envoi du formulaire à la vue
            'films' => $films, // Envoi du résultat du formulaire à la vue
        ]);
    }

    // Ajouter un film
    /**
     * @Route("/form/create", name="form2")
     */
    public function form2(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(FilmType::class); // Création du formulaire

        $form->handleRequest($request); // Gestion de la requête

        if($form->isSubmitted() && $form->isValid())
        {
            $film = $form->getData();

            $entityManager->persist($film);
            $entityManager->flush();

            $this->addFlash
            (
                'notice',
                'Votre film a bien été ajouté ! Il ne vous reste plus qu\'à trouver une page où vous pourrez voir le résultat ;-)'
            );

            return $this->redirectToRoute('form2');
        } elseif($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash
            (
                'alert',
                'Votre film n\'a pas été ajouté car il y\'a des erreurs dans le <a href="#add-form">formulaire en bas de page</a> !'
            );
        }

        return $this->render('main/form2.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'form2' => $form->createView(), // Envoi du formulaire à la vue
        ]);
    }

    // Mettre un jour un film
    /**
     * @Route("/form/update", name="form3")
     */
    public function form3(Request $request, FilmRepository $filmRepository)
    {
        // Récupération de la liste de tous les films
        $films = $filmRepository->findby([], ['titre' => 'ASC']);

        return $this->render('main/form3.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'films' => $films,
        ]);
    }

    // Supprimer un film
    /**
     * @Route("/form/delete", name="form4")
     */
    public function form4(Request $request, FilmRepository $filmRepository)
    {
        // Récupération de la liste de tous les films
        $films = $filmRepository->findby([], ['titre' => 'ASC']);

        return $this->render('main/form4.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'films' => $films,
        ]);
    }

    /**
     * @Route("/service", name="service")
     */
    public function service()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }

    /**
     * @Route("/auth", name="auth")
     */
    public function auth()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }

    /**
     * @Route("/references", name="references")
     */
    public function references()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }
}
