<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        //dd($films);

        return $this->render('main/db.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'form',
            'previous_route' => 'twig',
            'films' => $films,
        ]);
    }

    /**
     * @Route("/form", name="form") // à diviser en plusieurs pages pour exploiter le mappage du slug
     */
    public function form()
    {
        return $this->render('wip/index.html.twig', [
            'page_list' => $this->pageList,
            'next_route' => 'service',
            'previous_route' => 'db',
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
