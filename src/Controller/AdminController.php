<?php

namespace App\Controller;

use App\Services\NavManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $pageList;
    private $routeList;

    public function __construct(NavManager $nav)
    {
        $this->pageList = $nav->pageList;
        $this->routeList = $nav->routeList;
    }

    /**
     * @Route("/admin", name="admin")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }
}