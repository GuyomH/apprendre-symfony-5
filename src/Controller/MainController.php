<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use App\Service\NavManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->render('main/auth.html.twig', [
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
