<?php

namespace App\Controller;

use App\Form\SearchMoviesByDirectorType;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
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
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'page_list' => $this->pageList,
            'path_list' => $this->pathList,
        ]);
    }

    /**
     * @Route("/controller", name="controller")
     */
    public function controller()
    {
        return $this->render('main/controller.html.twig', [
            'page_list' => $this->pageList,
            'path_list' => $this->pathList,
        ]);
    }

    /**
     * @Route("/twig", name="twig")
     */
    public function twig()
    {
        return $this->render('main/twig.html.twig', [
            'page_list' => $this->pageList,
            'path_list' => $this->pathList,
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
            'path_list' => $this->pathList,
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
            'path_list' => $this->pathList,
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
            'path_list' => $this->pathList,
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
            'path_list' => $this->pathList,
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
            'path_list' => $this->pathList,
        ]);
    }

    /**
     * @Route("/service", name="service")
     */
    public function service()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'path_list' => $this->pathList,
        ]);
    }

    /**
     * @Route("/auth", name="auth")
     */
    public function auth()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'path_list' => $this->pathList,
        ]);
    }

    /**
     * @Route("/references", name="references")
     */
    public function references()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'path_list' => $this->pathList,
        ]);
    }
}
