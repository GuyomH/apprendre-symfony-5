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
        'Accueil' => 'index',
        'Contrôleur' => 'controller',
        'Twig' => 'twig',
        'Base de données' => 'db',
        'Formulaires' => [
            'Lire' => 'form1',
            'Créer' => 'form2',
            'Mettre à jour' => 'form3',
            'Supprimer' => 'form4',
            'Ajout multiple' => 'form5',
        ],
        'Service' => 'service',
        'Authentification' => 'auth',
        'Références' => 'references',
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
            'next_route' => 'form1',
            'previous_route' => 'twig',
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
            $films = $filmRepository->findBy($criteria); // résultat
        }

        return $this->render('main/form1.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'form2',
            'previous_route' => 'db',
            'form' => $form->createView(), // Envoi du formulaire à la vue
            'films' => $films, // Envoi du résultat du formulaire à la vue
        ]);
    }

    // Ajouter un film
    /**
     * @Route("/form/create", name="form2")
     */
    public function form2()
    {
        return $this->render('main/form2.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'form3',
            'previous_route' => 'form1',
        ]);
    }

    // Mettre un jour un film
    /**
     * @Route("/form/update", name="form3")
     */
    public function form3()
    {
        return $this->render('main/form3.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'form4',
            'previous_route' => 'form2',
        ]);
    }

    // Supprimer un film
    /**
     * @Route("/form/delete", name="form4")
     */
    public function form4()
    {
        return $this->render('main/form4.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'form5',
            'previous_route' => 'form3',
        ]);
    }

    // Ajouter plusieurs acteurs
    /**
     * @Route("/form/add_multiple", name="form5")
     */
    public function form5()
    {
        return $this->render('main/form5.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'service',
            'previous_route' => 'form4',
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
            'previous_route' => 'form5',
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
