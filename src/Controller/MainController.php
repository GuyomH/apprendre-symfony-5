<?php

namespace App\Controller;

use App\Entity\Realisateur;
use App\Form\SearchMoviesByDirectorType;
use App\Repository\FilmRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $pageList = [
        'index' => 'Accueil',
        'controller' => 'Contrôleur',
        'twig' => 'Twig',
        'db' => 'Base de données',
        'form' => 'Formulaire',
        'service' => 'Service',
        'auth' => 'Authentification',
        'references' => 'Références',
    ];

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'controller',
            'previous_route' => '',
        ]);
    }

    /**
     * @Route("/controller", name="controller")
     */
    public function controller()
    {
        return $this->render('main/controller.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'twig',
            'previous_route' => 'index',
        ]);
    }

    /**
     * @Route("/twig", name="twig")
     */
    public function twig()
    {
        return $this->render('main/twig.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'db',
            'previous_route' => 'controller',
        ]);
    }

    /**
     * @Route("/db", name="db")
     */
    public function db(FilmRepository $filmRepository)
    {
        $films = $filmRepository->findAll();

        return $this->render('main/db.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'form',
            'previous_route' => 'twig',
            'films' => $films,
        ]);
    }

    // Form 1 : Rechercher les films par réalisateur
    /**
     * @Route("/form", name="form")
     */
    public function form(Request $request, FilmRepository $filmRepository)
    {
        $films = []; // Initialisation du tableau contenant la liste des films
        $form = $this->createForm(SearchMoviesByDirectorType::class); // Création du formulaire avec notre classe de formulaire
        $form->handleRequest($request); // Obligatoire : gestion de la requête

        if($form->isSubmitted() && $form->isValid())
        {
            //dd($form);
            $criteria = $form->getData(); // Critères de recherche en provenance du formulaire
            //dd($criteria);
            $films = $filmRepository->findBy($criteria); // résultat
            //dd($films);
        }

        return $this->render('main/form.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'service',
            'previous_route' => 'db',
            'form' => $form->createView(), // Envoi du formulaire à la vue
            'films' => $films, // Envoi du résultat du formulaire à la vue
        ]);
    }

    /**
     * @Route("/service", name="service")
     */
    public function service()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'auth',
            'previous_route' => 'form',
        ]);
    }

    /**
     * @Route("/auth", name="auth")
     */
    public function auth()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'references',
            'previous_route' => 'service',
        ]);
    }

    /**
     * @Route("/references", name="references")
     */
    public function references()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => '',
            'previous_route' => 'auth',
        ]);
    }
}
