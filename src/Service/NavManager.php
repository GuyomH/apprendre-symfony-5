<?php


namespace App\Service;


class NavManager
{
    // Liste des pages du site par ordre séquentiel
    public $pageList = [
        'Accueil' => 'index',
        'Contrôleur' => 'controller',
        'Twig' => 'twig',
        'Base de données' => 'db',
        'Formulaires' => [
            'Lire des données' => 'read',
            'Ajouter des données' => 'create',
            'Mettre à jour des données' => 'update',
            'Supprimer des données' => 'delete',
        ],
        'Authentification' => 'auth',
        'Service' => 'service',
        'Références' => 'references',
    ];

    // Reconstruction de la liste des pages du site sans les sous-menus + inversion clé/valeur
    public $routeList = [];

    public function __construct()
    {
        foreach($this->pageList as $menuTitle => $routeName)
        {
            // Si le nom de la route est un titre de sous-menu
            if(is_array($routeName))
            {

                foreach($routeName as $menuTitle2 => $routeName2)
                {
                    $this->routeList[] = [$routeName2, $menuTitle2];
                }
            // Sinon on ajoute directement les valeurs dans le tableau
            } else {
                $this->routeList[] = [$routeName, $menuTitle];
            }
        }
    }
}