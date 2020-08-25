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
            'next_route' => '',
            'previous_route' => 'twig',
            'films' => $films,
        ]);
    }
}
