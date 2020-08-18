<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $pageList = [
        'index' => 'Accueil',
        'controller' => 'Contrôleur',
        'twig' => 'Twig',
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
            'next_route' => '',
            'previous_route' => 'controller',
        ]);
    }
}
