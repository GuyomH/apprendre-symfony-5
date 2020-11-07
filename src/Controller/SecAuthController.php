<?php

namespace App\Controller;

use App\Services\NavManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecAuthController extends AbstractController
{
    private $pageList;
    private $routeList;

    public function __construct(NavManager $nav)
    {
        $this->pageList = $nav->pageList;
        $this->routeList = $nav->routeList;
    }

    /**
     * @Route("/security/auth", name="auth")
     */
    public function auth()
    {
        return $this->render('sec_auth/auth.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }

    /**
     * @Route("/security/registration", name="registration")
     */
    public function registration()
    {
        return $this->render('sec_auth/registration.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }

    /**
     * @Route("/security/token", name="token")
     */
    public function token()
    {
        return $this->render('sec_auth/token.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }
}